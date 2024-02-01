<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Course;
use App\Models\Professor;

class CoursesController extends Controller
{

    function __construct()
    {
        $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index','store']]);
        $this->middleware('permission:room-create', ['only' => ['create','store']]);
        $this->middleware('permission:room-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $courses = Course::when($request->has('keyword'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->keyword . '%')
                ->orWhere('course_code', 'like', '%' . $request->keyword . '%');
        })
            ->when($request->has('filter') && $request->filter === 'no_professor', function ($query) {
                $query->doesntHave('professors');
            })
            ->orderBy('course_code')
            ->paginate(20);

        $professors = Professor::all();

        if ($request->ajax()) {
            return view('admin.courses.table', compact('courses'));
        }

        return view('admin.courses.index', compact('courses', 'professors'));
    }


    public function create()
    {
        $professors = Professor::all();

        return view('admin.courses.create', compact('professors'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
            'course_code' => 'required|unique:courses,course_code',
        ];

        $messages = [
            'name.unique' => 'This course already exists',
        ];

        $this->validate($request, $rules, $messages);

        $course = Course::create([
            'name' => $request->input('name'),
            'course_code' => $request->input('course_code'),
        ]);

        if ($course) {
            $course->professors()->sync($request->input('professor_ids', []));
            return response()->json(['message' => 'Course added'], 200);
        } else {
            return response()->json(['error' => 'A system error occurred'], 500);
        }
    }

    public function show($id, Request $request)
    {
        $course = Course::find($id);

        if ($course) {
            return response()->json($course, 200);
        } else {
            return response()->json(['error' => 'Course not found'], 404);
        }
    }


    public function edit($id)
    {
        $course = Course::with('professors')->find($id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $associatedProfessors = $course->professors;

        $allProfessors = Professor::all();

        return view('admin.courses.edit', compact('course', 'associatedProfessors', 'allProfessors'));
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required',
            'course_code' => 'required|unique:courses,course_code,' . $id,
        ];

        $messages = [
            'name.unique' => 'This course already exists',
        ];

        $this->validate($request, $rules, $messages);

        $course = Course::find($id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        $course->update([
            'name' => $request->input('name'),
            'course_code' => $request->input('course_code'),
        ]);

        $course->professors()->sync($request->input('professor_ids', []));

        return response()->json(['message' => 'Course updated'], 200);
    }

    public function destroy($id)
    {
        $course = Course::find($id);

        if (!$course) {
            return response()->json(['error' => 'Course not found'], 404);
        }

        if ($course->delete()) {
            return response()->json(['message' => 'Course has been deleted'], 200);
        } else {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }
    }
}
