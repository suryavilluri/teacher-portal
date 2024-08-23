<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AuthenticationController;
use App\Http\Controllers\TeacherController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "web" middleware group. Make something great!
|
*/

Route::get('/', function () {
    return view('login');
});
Route::get('/', [AuthenticationController::class, 'showLoginForm'])->name('home');
Route::get('/login', [AuthenticationController::class, 'showLoginForm'])->name('login');
Route::post('/teacher-login', [AuthenticationController::class, 'login'])->name('teacher.login');

Route::post('/logout', [AuthenticationController::class, 'logout'])->name('logout');

Route::middleware('auth:teacher')->group(function () {
    Route::get('/home', [TeacherController::class, 'index'])->name('teacher.home');
    Route::post('/student/add', [TeacherController::class, 'studentAdd']);
    Route::delete('delete-student/{id}', [TeacherController::class, 'deleteStudent']);
});


