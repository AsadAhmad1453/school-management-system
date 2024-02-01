<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Jobs\ForGetMail;
use App\Mail\AccountActivation;
use App\Mail\forgetPassword;
use App\Models\User;
use App\Providers\RouteServiceProvider;
use Illuminate\Foundation\Auth\AuthenticatesUsers;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class LoginController extends Controller
{
    use AuthenticatesUsers;

    protected $redirectTo = RouteServiceProvider::HOME;

    public function __construct()
    {
        $this->middleware('guest')->except('logout');
    }

    public function index()
    {
        return view('auth.login');
    }

    public function login()
    {
        if (isset(Auth()->user()->id)) {
            return redirect()->route('admin-panel-ms.index');
        } else {
            return view('auth.login');
        }
    }

    public function login_process(Request $request)
    {
        $request->validate([
            'email' => ['required', 'string', 'email', 'max:255'],
            'password' => 'required',
            // 'g-recaptcha-response' => 'required|captcha'
        ]);

        $user = User::where('email', $request['email'])->where('status', 1)->first();

        if ($user) {
            if (($user->type == "admin") && $user->status == 0) {
                $details = [
                    "name" => $user['name'],
                    "email" => $user['email'],
                    'code' => $user['code'],
                ];

                \Mail::to($user->email)->send(new AccountActivation($details));

                return redirect()->route('login')->with("message", "Your account is not verified. Please check your email inbox or spam folder to activate your account.");
            }

            if (Hash::check($request->password, $user->password)) {
                if (Auth::attempt(['email' => $request->email, 'password' => $request->password])) {
                    if ($user->type == "student") {
                        return redirect(route('home'));
                    } elseif ($user->type == "alumni") {
                        return redirect(route('home'));
                    } else {
                        return redirect(route('home'));
                    }
                } else {
                    return redirect()->back()->with('error', 'Please Enter Correct Email/Password');
                }
            }
        }
        return redirect()->back()->with('error', 'Please Enter Correct Email/Password');
    }

    public function view_forgetPassword()
    {
        return view('auth.passwords.forgetPassword');
    }

    public function post_forgetPassword(Request $request)
    {
        $request->validate([
            'email' => 'required',
            'g-recaptcha-response' => 'required|captcha',
        ]);

        $user = User::where('email', $request['email'])->get()->first();

        if ($user) {
            $details = [
                "name" => $user['name'],
                "email" => $user['email'],
                'code' => $user['code'],
            ];
            dispatch(new ForGetMail($user['email'], $details));
        }

        if ($user) {
            return back()->with("message", "Your reset password link has been sent successfully.");
        } else {
            return back()->with("error", "Try again! Email Not found");
        }
    }

    public function verify_user($code, $email)
    {
        // Decode the code
        $decodedCode = base64_decode($code);

        $user = User::where('code', $decodedCode)->where('email', $email)->first();

        if ($user) {
            $user->update(['status' => 1]);
            return redirect()->route('login')->with("message", "Your account is activated. You can now log in.");
        } else {
            return redirect()->route('login')->with("error", "Invalid verification link.");
        }
    }

    public function view_reset($id)
    {
        $user = User::where('code', base64_decode($id))->first();

        if ($user) {
            return view('auth.passwords.reset', compact('user'));
        } else {
            return view('auth.passwords.forgetPassword');
        }
    }

    public function post_reset(Request $request)
    {
        $request->validate([
            'password' => 'required',
        ]);

        $user = User::where('email', $request['email'])->where('code', $request['code'])->first();

        if ($user) {
            $result = $user->update([
                'password' => Hash::make($request['password']),
            ]);

            if ($result) {
                return redirect()->route('login')->with("message", "Thank you! Your password has been reset.");
            } else {
                return back()->with("error", "Try again!!!");
            }
        }
    }
}
