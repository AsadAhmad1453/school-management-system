<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Day;
use App\Models\Course;
use App\Models\Timeslot;
use App\Models\Professor;
use App\Models\UnavailableTimeslot;

class ProfessorsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index','store', 'create']]);
        $this->middleware('permission:room-create', ['only' => ['create','store']]);
        $this->middleware('permission:room-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $professors = Professor::when($request->has('keyword'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        })
            ->orderBy('name')
            ->paginate(20);

        $courses = Course::all();
        $days = Day::all();
        $timeslots = Timeslot::all();

        if ($request->ajax()) {
            return view('admin.professors.table', compact('professors'));
        }

        return view('admin.professors.index', compact('professors', 'courses', 'days', 'timeslots'));
    }

    public function create()
    {
        $courses = Course::all();
        $days = Day::all();
        $timeslots = Timeslot::all();
        return view('admin.professors.create', compact('courses', 'days', 'timeslots'));
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required',
        ];

        if ($request->has('email') && $request->email) {
            $rules['email'] = 'email';
        }

        $this->validate($request, $rules);

        $professor = Professor::create([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if (!$professor) {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }

        if ($request->has('course_ids')) {
            $professor->courses()->sync($request->input('course_ids'));
        }

        if ($request->has('unavailable_periods')) {
            foreach ($request->input('unavailable_periods') as $period) {
                $parts = explode(",", $period);
                $dayId = $parts[0];
                $timeslotId = $parts[1];

                $professor->unavailable_timeslots()->create([
                    'day_id' => $dayId,
                    'timeslot_id' => $timeslotId,
                ]);
            }
        }

        return response()->json(['message' => 'Professor added'], 200);
    }

    public function show($id)
    {
        $professor = Professor::find($id);
        $courseIds = [];
        $periods = [];

        if (!$professor) {
            return response()->json(['errors' => ['Professor not found']], 404);
        }

        foreach ($professor->courses as $course) {
            $courseIds[] = $course->id;
        }

        foreach ($professor->unavailable_timeslots as $period) {
            $periods[] = implode(",", [$period->day_id, $period->timeslot_id]);
        }

        $professor->course_ids = $courseIds;
        $professor->periods = $periods;

        return response()->json($professor, 200);
    }

    public function edit($id)
    {
        $professor = Professor::findOrFail($id);
        $courses = Course::all();
        $days = Day::all();
        $timeslots = Timeslot::all();

        $professorCourseIds = $professor->courses->pluck('id')->toArray();

        $professorUnavailablePeriods = $professor->unavailable_timeslots->map(function ($period) {
            return $period->day_id . ',' . $period->timeslot_id;
        })->toArray();

        return view('admin.professors.edit', compact('professor', 'courses', 'professorCourseIds', 'days', 'timeslots', 'professorUnavailablePeriods'));


    }

    public function update($id, Request $request)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['errors' => ['Professor does not exist']], 404);
        }

        $rules = [
            'name' => 'required',
        ];

        if ($request->has('email') && $request->email) {
            $rules['email'] = 'email';
        }

        $this->validate($request, $rules);

        $professor->update([
            'name' => $request->input('name'),
            'email' => $request->input('email'),
        ]);

        if ($request->has('course_ids')) {
            $professor->courses()->sync($request->input('course_ids'));
        }

        if ($request->has('unavailable_periods')) {
            foreach ($request->input('unavailable_periods') as $period) {
                $parts = explode(",", $period);
                $dayId = $parts[0];
                $timeslotId = $parts[1];

                $existing = $professor->unavailable_timeslots()
                    ->where('day_id', $dayId)
                    ->where('timeslot_id', $timeslotId)
                    ->first();

                if (!$existing) {
                    $professor->unavailable_timeslots()->create([
                        'day_id' => $dayId,
                        'timeslot_id' => $timeslotId,
                    ]);
                }
            }

            foreach ($professor->unavailable_timeslots as $period) {
                if ($period->day && $period->timeslot) {
                    $periodString = implode(",", [$period->day->id, $period->timeslot->id]);
                }

                if (!in_array($periodString, $request->input('unavailable_periods', []))) {
                    $period->delete();
                }
            }
        } else {
            foreach ($professor->unavailable_timeslots as $period) {
                $period->delete();
            }
        }

        return response()->json(['message' => 'Professor updated'], 200);
    }

    public function destroy($id)
    {
        $professor = Professor::find($id);

        if (!$professor) {
            return response()->json(['error' => 'Professor not found'], 404);
        }

        if ($professor->delete()) {
            return response()->json(['message' => 'Professor has been deleted'], 200);
        } else {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }
    }
}
