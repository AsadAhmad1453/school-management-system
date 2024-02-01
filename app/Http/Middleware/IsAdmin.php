<?php

namespace App\Http\Middleware;

use Closure;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class IsAdmin
{

    public function handle(Request $request, Closure $next)
    {
        if (Auth::check()) {
            $userType = auth()->user()->type;
            if (in_array($userType, ['admin'])) {
                return $next($request);
            }
        }
        return redirect()->route('home');
        //return response()->json('Your are not allowed as a Applicant');
    }

}
