<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Timetable;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\DB;
use App\Models\CollegeClass;
use App\Models\AcademicPeriod;
use App\Events\TimetablesRequested;

class TimetablesController extends Controller
{
    /**
     * Create a new instance of this controller and set up
     * middlewares on this controller methods
     */
    function __construct()
    {
        $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index','store']]);
        $this->middleware('permission:room-create', ['only' => ['create','store']]);
        $this->middleware('permission:room-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    /**
     * Handle ajax request to load timetable to populate
     * timetables table on the dashboard
     */
    public function index()
    {
        $timetables = Timetable::orderBy('created_at', 'DESC')->paginate(10);

        return view('admin.timetables.index', compact('timetables'));
    }

    /**
     * Create a new timetable object and hand over to the genetic algorithm
     * to generate
     *
     * @param \Illuminate\Http\Request $request The HTTP request
     */
    public function store(Request $request)
    {
        // Initialize $dayIds array
        $dayIds = [];

        // Fetch all days from the days table
        $days = Day::all();

        foreach ($days as $day) {
            if ($request->has('day_' . $day->id)) {
                $dayIds[] = $day->id;
            }
        }

        $classes = CollegeClass::all();
        $classNames = [];

        foreach ($classes as $class) {
            $classNames[] = $class->name;
        }

// Join class names with a space
        $classList = implode(' ', $classNames);

// Now you can use $classList in your $name variable
        $name = $classList . ' ' . $request->academic_year;



        // Fetch academic period ID from the AcademicPeriod model
        $academicPeriodIds = AcademicPeriod::pluck('id')->first();

        // Check creation conditions
        $otherChecks = $this->checkCreationConditions();

        if (count($otherChecks)) {
            return response()->json(['errors' => $otherChecks], 422);
        }



        $timetable = Timetable::create([
            'user_id' => Auth::user()->id,
            'academic_period_id' => $academicPeriodIds,
            'status' => 'IN PROGRESS',
            'name' => $name,
        ]);
        if ($timetable) {
            $timetable->days()->sync($dayIds);
        }

        event(new TimetablesRequested($timetable));

        return redirect()->route('timetables.index')->with('success', 'Timetables are being generated. Check back later');
    }

    /**
     * Display a printable view of the timetable set
     *
     * @param int $id
     */
    public function view($id)
    {
        $timetable = Timetable::find($id);

        if (!$timetable) {
            return redirect()->route('dashboard'); // Redirect to a proper route
        } else {
            $path = $timetable->file_url;
            $timetableData = Storage::get($path);
            $timetableName = $timetable->name;
            return view('admin.timetables.view', compact('timetableData', 'timetableName'));
        }
    }

    /**
     * Check that everything is intact to create a timetable set
     * Return errors from the check
     *
     * @return array Errors from the check
     */
    private function checkCreationConditions()
    {
        $errors = [];

        $coursesQuery = 'SELECT id FROM courses WHERE id NOT IN (SELECT DISTINCT course_id FROM courses_professors)';
        $courseIds = DB::select($coursesQuery);

        if (count($courseIds)) {
            $errors[] = "Some courses don't have professors. <a href=\"/class/public/courses?filter=no_professor\" target=\"_blank\">Click here to review them</a>";
        }

        if (!CollegeClass::count()) {
            $errors[] = "No classes have been added";
        }

        $classesQuery = 'SELECT id FROM classes WHERE id NOT IN (SELECT DISTINCT class_id FROM courses_classes)';
        $classIds = DB::select($classesQuery);

        if (count($classIds)) {
            $errors[] = "Some classes don't have any course set up. <a href=\"/class/public/classes?filter=no_course\" target=\"_blank\">Click here to review them</a>";
        }

        return $errors;
    }
}
