<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;

use App\Models\Department;
use DB;
use Hash;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Maatwebsite\Excel\Facades\Excel;
use Spatie\Permission\Models\Role;

class UserController extends Controller
{

   function __construct()
    {
        $this->middleware('permission:user-list|user-create|user-edit|user-delete', ['only' => ['index', 'store']]);
        $this->middleware('permission:user-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:user-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:unverify-user', ['only' => ['unverified_user']]);
        $this->middleware('permission:user-delete', ['only' => ['destroy']]);
    }

    public function index(Request $request)
    {
        $data = User::orderBy('id', 'DESC')->get();

        return view('admin.users.index', compact('data'));
    }


    public function create()
    {
        $roles = Role::all();
        return view('admin.users.create', compact('roles'));
    }


    public function store(Request $request)
    {
        $name = '';
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email',
            'password' => 'required|confirmed',
            'roles' => 'required',
            'phone' => 'required',
        ]);


        if ($request->hasfile('image')) {
            $name = $request['image']->getClientOriginalName();
            $request['image']->move(public_path() . '/assets/images/user', $name);
        }
        $result = User::create([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'image' => ($request['image'] ? $name : null),
            'password' => Hash::make($request['password']),
            'status' =>1,
            'type' => 'admin',
            'gender' => $request['gender'],

        ]);
        $result->assignRole($request->input('roles'));

        return redirect()->route('users.index')
            ->with('message', 'User created successfully.');
    }


    public function show($id)
    {
        $user = User::find($id);

        return view('admin.show', compact('user'));
    }


    public function edit($id)
    {
        $user = User::find($id);
        $roles = Role::all();
        $userRole = $user->roles->all();
        return view('admin.users.edit', compact('user', 'roles', 'userRole'));
    }


    public function update(Request $request, $id)
    {
        $this->validate($request, [
            'name' => 'required',
            'email' => 'required|email|unique:users,email,' . $id,
            'status' => 'required',
            'type' => 'required',

        ]);

        $result = User::where('id', $id)->update([
            'name' => $request['name'],
            'email' => $request['email'],
            'phone' => $request['phone'],
            'gender' => $request['gender'],
            'status' => $request['status'],
       //     'type' => $request['type'],

        ]);
        /*if(!empty($input['password'])) {
            $input['password'] = Hash::make($input['password']);
        } else {
            $input = Arr::except($input, array('password'));
        }*/

        $user = User::find($id);
        //   $user->update($input);

        if ($request['type'] == "admin") {
        //    dd("ss");
            $this->validate($request, [
                'roles' => 'required',
            ]);

            DB::table('model_has_roles')
                ->where('model_id', $id)
                ->delete();

            $user->assignRole($request->input('roles'));
        }

        return redirect()->route('users.index')
            ->with('message', 'User updated successfully.');
    }

    public function destroy($id)
    {
        User::find($id)->delete();

        return redirect()->route('users.index')
            ->with('success', 'User deleted successfully.');
    }


    public function get_profile()
    {
        $departments = Department:: all();
        return view('admin.users.profile', compact('departments'));
    }

    public function get_password()
    {
        return view('admin.users.password');
    }


    public function post_password(Request $request)
    {

        if (Hash::check($request['password'], Auth::user()->password)) {
            $request = User::where('id', Auth::user()->id)->update([

                'password' => Hash::make($request['newPassword'])

            ]);
            return redirect()->route('get.password')->with("message", "Password updated successfully");

        } else {
            return redirect()->route('get.password')->with("error", "Try again!!!");

        }
    }


    public function post_profile(Request  $request)
    {

        $this->validate($request, [
            'name' => 'required',
            'phone' => 'required',
            'gender' => 'required',
            'designation' => 'required',
            'department' => 'required',
            'dob' => 'required',

        ]);

        $result = User::where('id', Auth::user()->id)->update([
            'name' => $request['name'],
            'phone' => $request['phone'],
            'gender' => $request['gender'],
            'designation' => $request['designation'],
            'department' => $request['department'],
            'dob' => $request['dob'],
        ]);

        if ($result)
        {
            return redirect()->back()
                ->with('message', 'update successfully.');
        }
        else
        {
            return redirect()->back()
                ->with('error', 'Try again.');
        }
    }


    public function post_profile_image(Request $request)
    {

        $result = '';
        if ($request->hasfile('image')) {
            $extension = $request['image']->getClientOriginalExtension();
            if (strtolower($extension) == "php") {
                return response()->json([
                    'success' => 'Not allowed',
                ]);
            }
            if (Auth::user()->image != null) {
                $image_path = public_path("/admin/images/user/" . Auth::user()->image);
                if (File::exists($image_path)) {
                    File::delete($image_path);
                }
            }
            $extension = $request['image']->getClientOriginalExtension();
                $image = Auth::user()->id.'-' .rand(2,10000). '.' . $extension;
                $request['image']->move(public_path() . '/admin/images/user/', $image);
                $result = User::where('id', Auth::user()->id)->update([
                    'image' => $image,
                ]);
        }
        if ($result) {
            return response()->json([
                'success' => 'Image Upload Successfully',
            ]);
        } else {
            return back()->with('error', 'try again');
        }
    }

}
