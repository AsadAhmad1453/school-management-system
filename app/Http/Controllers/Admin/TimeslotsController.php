<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;
use App\Models\Timeslot;

class TimeslotsController extends Controller
{
    /**
     * Create a new instance of this controller
     */
    function __construct()
    {
        $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:room-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:room-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    /**
     * Get a listing of timeslots
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function index(Request $request)
    {
        $query = Timeslot::query();

        if ($request->has('keyword')) {
            $query->where('column_name', 'like', '%' . $request->keyword . '%');
        }

        $timeslots = $query->orderBy('rank')->paginate(20);

        if ($request->ajax()) {
            return view('admin.timeslots.table', compact('timeslots'));
        }

        return view('admin.timeslots.index', compact('timeslots'));
    }

    public function create()
    {
        return view('admin.timeslots.create');
    }

    public function edit($id)
    {
        $timeslot = Timeslot::find($id);

        if (!$timeslot) {
            return response()->json(['error' => 'Timeslot not found'], 404);
        }

        // You might want to customize this based on your application's requirements
        $timeParts = explode("-", $timeslot->time);
        $timeslot->from = trim($timeParts[0]);
        $timeslot->to = trim($timeParts[1]);

        return view('admin.timeslots.edit', compact('timeslot'));
    }

    /**
     * Add a new timeslot
     *
     * @param Illuminate\Http\Request $request The HTTP request
     */
    public function store(Request $request)
    {
        $rules = [
            'from' => 'required|before:to',
            'to' => 'required|after:from'
        ];

        $messages = [
            'from.before' => 'From time must be before To time',
            'to.after' => 'To time must be after From time'
        ];

        $this->validate($request, $rules, $messages);

        $exists = Timeslot::where('time', Timeslot::createTimePeriod($request->from, $request->to))->first();

        if ($exists) {
            return response()->json(['errors' => ['This timeslot already exists']], 422);
        }

        $data = $request->all();
        $data['time'] = Timeslot::createTimePeriod($data['from'], $data['to']);

        $timeslots = Timeslot::all();

        foreach ($timeslots as $timeslot) {
            if ($timeslot->containsPeriod($data['time'])) {
                $errors = [$data['time'] . ' falls within another timeslot (' . $timeslot->time
                    . '). Please adjust timeslots'];
                return response()->json(['errors' => $errors], 422);
            }
        }

        // Use the create method without storing the result in a variable
        Timeslot::create($data);


        return response()->json(['message' => 'Timeslot has been added'], 200);
    }


    /**
     * Get the timeslot with the given ID
     *
     * @param int $id The timeslot id
     */
    public function show($id)
    {
        $timeslot = Timeslot::find($id);

        if ($timeslot) {
            $timeParts = explode("-", $timeslot->time);
            $timeslot->from = trim($timeParts[0]);
            $timeslot->to = trim($timeParts[1]);

            return response()->json($timeslot, 200);
        } else {
            return response()->json(['error' => 'Timeslot not found'], 404);
        }
    }

    /**
     * Update the timeslot with the given Id
     *
     * @param int $id The id of the timeslot to update
     * @param Illuminat\Http\Request $request The HTTP request
     */
    public function update($id, Request $request)
    {
        $timeslot = Timeslot::find($id);

        if (!$timeslot) {
            return response()->json(['errors' => ['Timeslot not found']], 404);
        }

        $rules = [
            'from' => 'required|before:to',
            'to' => 'required|after:from'
        ];

        $messages = [
            'from.before' => 'From time must be before To time',
            'to.after' => 'To time must be after From time'
        ];

        $this->validate($request, $rules, $messages);

        $exists = Timeslot::where('time', Timeslot::createTimePeriod($request->from, $request->to))
            ->where('id', '<>', $id)
            ->first();

        if ($exists) {
            return response()->json(['errors' => ['This timeslot already exists']], 422);
        }

        $data = $request->all();
        $data['time'] = Timeslot::createTimePeriod($data['from'], $data['to']);

        $timeslots = Timeslot::all();

        foreach ($timeslots as $otherTimeslot) {
            if ($otherTimeslot->id != $id && $otherTimeslot->containsPeriod($data['time'])) {
                $errors = [$data['time'] . ' falls within another timeslot (' . $otherTimeslot->time
                    . '). Please adjust timeslots'];
                return response()->json(['errors' => $errors], 422);
            }
        }

        // Update the existing timeslot
        $timeslot->update($data);

        // Removed the event dispatching
        // event(new TimeslotsUpdated());

        return response()->json(['message' => 'Timeslot updated'], 200);
    }


    /**
     * Delete the timeslot with the given id
     *
     * @param int $id The id of the timeslot to delete
     */
    public function destroy($id)
    {
        $timeslot = Timeslot::find($id);

        if (!$timeslot) {
            return response()->json(['error' => 'Timeslot not found'], 404);
        }

        if ($timeslot->delete()) {
            return response()->json(['message' => 'Timeslot has been deleted'], 200);
        } else {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }
    }
}
