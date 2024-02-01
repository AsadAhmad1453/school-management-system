<?php

namespace App\Http\Controllers;

use App\Models\CourseSection;
use App\Models\Room;
use App\Models\Timeslot;
use Illuminate\Http\Request;

use App\Models\ExamSchedule;
use App\Models\Session;
use App\Models\Semester;
use App\Models\Department;
use App\Models\Day;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMultipleSheets;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Facades\Excel;
use Illuminate\Support\Facades\DB;

class ScheduleController extends Controller
{
    public function index()
    {
        $schedules = ExamSchedule::all();
        return view('schedules.index', compact('schedules'));
    }


    public function create()
    {
        $sessions = Session::all();
        $days = Day::all();
        return view('schedules.create', compact('sessions', 'days'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'session_id' => 'required',
            'day' => 'required|array',
        ]);

        $selectedDays = $request->input('day');

        // Check if any course section is already scheduled for the selected day or days
        if (ExamSchedule::whereIn('day_id', $selectedDays)->exists()) {
            return redirect()->route('schedules.index')->with('error', 'Course section is already scheduled for the selected day or days.');
        }

        // Get all available course sections
        $courseSections = CourseSection::all();

        $semesters = $courseSections->groupBy('semester_id');

        foreach ($selectedDays as $selectedDay) {
            foreach ($semesters as $semesterId => $semesterCourseSections) {
                $departments = $semesterCourseSections->groupBy('department_id');

                foreach ($departments as $departmentId => $departmentCourseSections) {
                    foreach ($departmentCourseSections as $availableCourseSection) {
                        // Check if the course section is already scheduled for any day
                        if (ExamSchedule::where('course_section_id', $availableCourseSection->id)->exists()) {
                            continue; // Skip scheduling for this course section
                        }

                        // Determine the timeslot based on the semester
                        $timeslotNumber = ($semesterId - 1) % 2 + 1;
                        $timeslot = Timeslot::where('id', $timeslotNumber)->first();

                        $scheduleName = $departmentCourseSections->first()->department->name . ' - ' . $availableCourseSection->name;

                        // Get the total number of students enrolled in the course section
                        $totalStudents = $availableCourseSection->students()->count();

                        // Create a new schedule
                        ExamSchedule::create([
                            'session_id' => $request->session_id,
                            'department_id' => $departmentId,
                            'exam_semester_id' => $semesterId,
                            'course_section_id' => $availableCourseSection->id,
                            'day_id' => $selectedDay,
                            'room_id' => 1,
                            'slot_id' => $timeslot->id,
                            'name' => $scheduleName,
                            'total_students' => $totalStudents,
                        ]);

                        // Break the loop after scheduling one course section for the selected day
                        break;
                    }
                }
            }
        }

        return redirect()->route('schedules.index')->with('success', 'Schedules created successfully.');
    }

    public function printSchedules()
    {

        $schedules = ExamSchedule::with(['semester', 'slots', 'rooms', 'days', 'departments', 'courseSections.subjects'])->get();


        $groupedSchedules = $schedules->groupBy('department_id')->map(function ($departmentSchedules) {
            return $departmentSchedules->groupBy('day_id');
        });


        $sheets = [];

        foreach ($groupedSchedules as $departmentId => $departmentDays) {
            $departmentName = optional($departmentDays->first()->first()->departments)->name;


            $exportData = collect();
            $exportData->push(['Subject Code', 'Subject Name', 'Semester', 'Total Students', 'Time', 'Room']);

            foreach ($departmentDays as $dayId => $schedules) {
                $dayName = optional($schedules->first()->days)->name;
                $exportData->push([$dayName]);

                foreach ($schedules as $schedule) {
                    $startTime = optional($schedule->slots)->time ? trim(explode('-', optional($schedule->slots)->time)[0]) : null;
                    $subjectCode = optional($schedule->courseSections)->subjects->code;
                    $subjectName = optional($schedule->courseSections)->subjects->name;
                    $semesterName = optional($schedule->semester)->name;
                    $venue = optional($schedule->rooms)->name;
                    $totalStudents = $schedule->total_students;

                    $exportData->push([
                        'Subject Code' => $subjectCode,
                        'Subject Name' => $subjectName,
                        'Semester' => $semesterName,
                        'Total Students' => $totalStudents,
                        'Start Time' => $startTime,
                        'Venue' => $venue,
                    ]);
                }
            }

            $sheets[] = new class($exportData, $departmentName) implements FromCollection, WithTitle {
                protected $exportData;
                protected $departmentName;

                public function __construct($exportData, $departmentName)
                {
                    $this->exportData = $exportData;
                    $this->departmentName = $departmentName;
                }

                public function collection()
                {
                    return $this->exportData;
                }

                public function title(): string
                {
                    return $this->departmentName;
                }
            };
        }


        return Excel::download(new class($sheets) implements WithMultipleSheets {
            protected $sheets;

            public function __construct($sheets)
            {
                $this->sheets = $sheets;
            }

            public function sheets(): array
            {
                return $this->sheets;
            }
        }, 'schedules.xlsx');
    }

    public function destroy($id)
    {
        $schedule = ExamSchedule::findOrFail($id);
        $schedule->delete();

        return redirect()->route('schedules.index')->with('success', 'Schedule deleted successfully.');
    }

}