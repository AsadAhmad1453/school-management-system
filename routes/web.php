<?php

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Auth\LoginController;
use App\Http\Controllers\Auth\RegisterController;
use Illuminate\Support\Facades\Redirect;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
/* ************************** Pages for news, events etc ************************************ */
Route::get('/', [LoginController::class, 'login'])->name('user.login');

/* ************************** Login  Pages for news, events etc ************************************ */
Route::get('admin/login', [LoginController::class, 'login'])->name('user.login');
Route::post('admin/login/process', [LoginController::class, 'login_process'])->name('post.login');
Route::get('forgetPassword', [LoginController::class, 'view_forgetPassword'])->name('view.forgetpassword');
Route::post('forgetPassword/post', [LoginController::class, 'post_forgetPassword'])->name('post.forgetpassword');
Route::get('resetPassword/{id}', [LoginController::class, 'view_reset'])->name('view.reset');
Route::post('resetPassword/post', [LoginController::class, 'post_reset'])->name('post.reset');
Route::post('register/process', [RegisterController::class, 'store'])->name('post.register');
Route::get('verifyUser/{id}/{email}', [LoginController::class, 'verify_user'])->name('view.verify');
Route::get('user/logout', function () {  auth()->logout(); Session()->flush();    return Redirect::to('/');})->name('user.logout');





include "admin.php";


