<?php

use App\Http\Controllers\FreeDaysRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminViewController;

Route::get('/home', function () {
    return view('home');
});


Route::get('/free-day-request', [\App\Http\Controllers\FreeDaysRequestController::class, 'index']);
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::get('/login', [\App\Http\Controllers\LoginController::class, 'create'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store']);
Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);
Route::get('/holidays', [\App\Http\Controllers\OfficialHolidayController::class, 'getHolidays']);
Route::get('/official-holiday', [\App\Http\Controllers\OfficialHolidayController::class, 'index']);






