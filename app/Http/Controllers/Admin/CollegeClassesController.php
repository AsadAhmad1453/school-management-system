<?php


namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Room;
use App\Models\Course;
use App\Models\CollegeClass;
use App\Models\AcademicPeriod;

class CollegeClassesController extends Controller
{

    public function index(Request $request)
    {
        $classes = CollegeClass::query()
            ->when($request->has('keyword'), function ($query) use ($request) {
                $query->where('name', 'like', '%' . $request->keyword . '%');
            })
            ->when($request->has('filter'), function ($query) use ($request) {
                // Add your filter logic here
            })
            ->orderBy('name')
            ->paginate(20);

        $rooms = Room::all();
        $courses = Course::all();
        $academicPeriods = AcademicPeriod::all();

        if ($request->ajax()) {
            return view('classes.table', compact('classes', 'academicPeriods'));
        }

        return view('admin.classes.index', compact('classes', 'rooms', 'courses', 'academicPeriods'));
    }

    public function create()
    {
        $courses = Course::all();
        $academicPeriods = AcademicPeriod::all();
        $rooms = Room::all();

        return view('admin.classes.create', compact('courses', 'academicPeriods', 'rooms'));
    }



    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|unique:classes,name',
            'course' => 'required|array',
            'course.*' => 'exists:courses,id',
            'period' => 'required|array',
            'period.*' => 'exists:academic_periods,id',
            'course-meetings' => 'required|array',
            'size' => 'required|numeric',
            'room_ids' => 'nullable|array',
        ]);

        // Create a new class instance
        $class = CollegeClass::create([
            'name' => $request->input('name'),
            'size' => $request->input('size'),
        ]);

        // Attach courses to the class using the pivot table
        for ($i = 0; $i < count($request->input('course')); $i++) {
            $course = Course::find($request->input('course')[$i]);
            $academicPeriod = AcademicPeriod::find($request->input('period')[$i]);

            $class->courses()->attach($course, [
                'academic_period_id' => $academicPeriod->id,
                'meetings' => $request->input('course-meetings')[$i],
            ]);
        }

        // Attach unavailable rooms to the class
        $class->unavailable_rooms()->sync($request->input('room_ids', []));

        // Redirect or respond accordingly
        return redirect()->route('classes.index')->with('success', 'Class created successfully');
    }




    public function show($id)
    {
        $class = CollegeClass::find($id);

        if ($class) {
            return response()->json($class, 200);
        } else {
            return response()->json(['error' => 'Class not found'], 404);
        }
    }

    public function edit($id)
    {
        $class = CollegeClass::find($id);

        if (!$class) {
            return abort(404); // or return a view indicating that the class was not found
        }

        $courses = Course::all();
        $academicPeriods = AcademicPeriod::all();
        $rooms = Room::all();

        // Fetching unavailable room IDs
        $roomIDs = $class->unavailable_rooms->pluck('id')->toArray();

        return view('admin.classes.edit', compact('class', 'courses', 'academicPeriods', 'roomIDs', 'rooms'));
    }


    public function update($id, Request $request)
    {
        $request->validate([
            'name' => 'required|unique:classes,name,' . $id,
            'size' => 'required',
            'course' => 'required|array',
            'period' => 'required|array',
            'course-meetings' => 'required|array',
            'room_ids' => 'nullable|array',
        ]);

        // Remove null values from arrays
        $request['course'] = array_filter($request->input('course'));
        $request['period'] = array_filter($request->input('period'));
        $request['course-meetings'] = array_filter($request->input('course-meetings'));

        $class = CollegeClass::findOrFail($id);

        // Initialize arrays to store course data
        $coursesData = [];

        foreach ($request->input('course') as $index => $courseId) {
            $academicPeriodId = $request->input('period')[$index];
            $meetings = $request->input('course-meetings')[$index];

            // Add course data to the array
            $coursesData[] = [
                'course_id' => $courseId,
                'academic_period_id' => $academicPeriodId,
                'meetings' => $meetings,
            ];
        }

        // Update class attributes
        $class->update([
            'name' => $request->input('name'),
            'size' => $request->input('size'),
        ]);

        // Sync courses data
        $class->courses()->sync($coursesData);

        // Sync unavailable rooms
        $class->unavailable_rooms()->sync($request->input('room_ids', []));

        return redirect()->route('classes.index')->with('success', 'Class updated.');
    }








    public function destroy($id)
    {
        $class = CollegeClass::find($id);

        if (!$class) {
            return response()->json(['error' => 'Class not found'], 404);
        }

        $class->delete();

        return response()->json(['message' => 'Class has been deleted'], 200);
    }
}
