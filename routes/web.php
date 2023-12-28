<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Support\Facades\Auth;

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
    return view('welcome');
});

Auth::routes();

Route::get('/login', [App\Http\Controllers\HomeController::class, 'index'])->name('login');

Route::get('/', function () {
    if (Auth::check()) {
        // The user is logged in, redirect them to the first page
        return redirect()->route('schedule');
    } else {
        // The user is not logged in, redirect them to the second page
        return redirect()->route('login');
    }
});

Route::get('/schedule', function () {
    return view('schedule.schedule');
})->name('schedule');

Route::get('/schedule/addevent', function () {
    return view('schedule.addevent');
})->middleware('admin')->name('addevent');

Route::get('/schedule/checksignups', function () {
    return view('schedule.checksignups');
})->name('checksignups');

Route::post('/events', [App\Http\Controllers\EventsController::class, 'store'])->name('events.store');
Route::get('/events', [App\Http\Controllers\EventsController::class, 'getEvents']);

Route::post('/signup', [\App\Http\Controllers\SignupController::class, 'store']);
Route::post('/signout', [\App\Http\Controllers\SignupController::class, 'destroy'])->name('signout');
Route::post('/check', [\App\Http\Controllers\SignupController::class, 'check'])->name('check');
Route::get('/lijst', [\App\Http\Controllers\SignupController::class, 'getUserEvents'])->name('lijst');