<?php

namespace App\Exceptions;

use Exception;
use Illuminate\Database\QueryException;
use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * A list of the exception types that are not reported.
     *
     * @var array<int, class-string<Throwable>>
     */
    protected $dontReport = [
        //
    ];

    /**
     * A list of the inputs that are never flashed for validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     *
     * @return void
     */
    public function register()
    {
        $this->reportable(function (Throwable $e) {
            //
        });
    }

    /*public function render($request, Exception $exception)
    {
        // Customize the response for different types of exceptions
        if ($exception instanceof \PDOException) {
            //dd('ss');
            return response()->json(['message' => 'A database error occurred.'], 403);
        }
        if ($exception instanceof QueryException) {
            return response()->json(['message' => 'A database error occurred.'], 404);
        }
        elseif ($exception instanceof \Illuminate\Auth\AuthenticationException) {
            return redirect()->guest(route('login'));
        } else {
            return parent::render($request, $exception); // Use default exception handling
        }
    }*/
}
