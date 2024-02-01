<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Room;

class RoomsController extends Controller
{
    function __construct()
    {
        $this->middleware('permission:room-list|room-create|room-edit|room-delete', ['only' => ['index','store', 'create', 'edit']]);
        $this->middleware('permission:room-create', ['only' => ['create','store']]);
        $this->middleware('permission:room-edit', ['only' => ['edit','update']]);
        $this->middleware('permission:room-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $rooms = Room::when($request->has('keyword'), function ($query) use ($request) {
            $query->where('name', 'like', '%' . $request->keyword . '%');
        })
            ->orderBy('name')
            ->paginate(20);

        if ($request->ajax()) {
            return view('rooms.table', compact('rooms'));
        }

        return view('admin.rooms.index', compact('rooms'));
    }

    public function create()
    {
        return view('admin.rooms.create');
    }

    public function store(Request $request)
    {
        $rules = [
            'name' => 'required|unique:rooms,name',
            'capacity' => 'required|numeric',
        ];

        $messages = [
            'name.unique' => 'This room already exists',
        ];

        $this->validate($request, $rules, $messages);

        $room = Room::create([
            'name' => $request->input('name'),
            'capacity' => $request->input('capacity'),
        ]);

        if ($room) {
            return response()->json(['message' => 'Room added'], 200);
        } else {
            return response()->json(['error' => 'A system error occurred'], 500);
        }
    }

    public function show($id, Request $request)
    {
        $room = Room::find($id);

        if ($room) {
            return response()->json($room, 200);
        } else {
            return response()->json(['error' => 'Room not found'], 404);
        }
    }

    public function edit($id)
    {
        $room = Room::findOrFail($id);
        return view('admin.rooms.edit', compact('room'));
    }

    public function update($id, Request $request)
    {
        $rules = [
            'name' => 'required|unique:rooms,name,' . $id,
            'capacity' => 'required|numeric',
        ];

        $messages = [
            'name.unique' => 'This room already exists',
        ];

        $this->validate($request, $rules, $messages);

        $room = Room::find($id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        $room->update([
            'name' => $request->input('name'),
            'capacity' => $request->input('capacity'),
        ]);

        return response()->json(['message' => 'Room updated'], 200);
    }

    public function destroy($id)
    {
        $room = Room::find($id);

        if (!$room) {
            return response()->json(['error' => 'Room not found'], 404);
        }

        if ($room->delete()) {
            return response()->json(['message' => 'Room has been deleted'], 200);
        } else {
            return response()->json(['error' => 'An unknown system error occurred'], 500);
        }
    }
}
