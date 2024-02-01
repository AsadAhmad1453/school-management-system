<?php


/*use App\Http\Controllers\Admin\LogsController;*/

use App\Http\Controllers\Admin\HomeController;
use App\Http\Controllers\Admin\PermissionController;
use App\Http\Controllers\Admin\RoleController;
use App\Http\Controllers\Admin\UserController;
use App\Http\Controllers\Admin\RoomsController;
use App\Http\Controllers\Admin\CoursesController;
use App\Http\Controllers\Admin\TimeslotsController;
use App\Http\Controllers\Admin\ProfessorsController;
use App\Http\Controllers\Admin\CollegeClassesController;
use App\Http\Controllers\Admin\TimetablesController;


Auth::routes([]);

Route::group(['middleware' => ['auth']], function () {

/* ------------------------------------- Get Routes ----------------------------------------------------*/
    Route::get('dashboard', [HomeController::class, 'index'])->name('home');
    Route::get('user/profile', [UserController::class, 'get_profile'])->name('get.profile');
    Route::get('user/password', [UserController::class, 'get_password'])->name('get.password');





    /* ------------------------------------- Resources Routes ----------------------------------------------------*/
    Route::resource('roles', RoleController::class);
    Route::resource('permissions', PermissionController::class);
    /*    Route::resource('logs',LogsController::class);*/
    Route::resource('users', UserController::class);
    Route::resource('rooms', RoomsController::class);
    Route::resource('courses', CoursesController::class);
    Route::resource('timeslots', TimeslotsController::class);
    Route::resource('professors', ProfessorsController::class);
    Route::resource('classes', CollegeClassesController::class);
    Route::resource('timetables', TimetablesController::class);
    Route::get('addtimetable',[TimetablesController::class,'addtimetable'])->name('add-time-table');
    Route::get('timetables/view/{id}', [TimetablesController::class, 'view'])->name('timetables.view');



    /* ------------------------------------- Post Routes ----------------------------------------------------*/
    Route::post('/applicant/profile/image', [UserController::class, 'post_profile_image'])->name('post.image');
    Route::post('user/password/post', [UserController::class, 'post_password'])->name('post.password');
    Route::post('user/profile/post', [UserController::class, 'post_profile'])->name('post.profile');





});
