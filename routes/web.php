<?php

use App\Http\Controllers\FreeDaysRequestController;
use App\Http\Controllers\OfficialHolidayController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('home');
});


Route::get('/free-day-request', [FreeDaysRequestController::class, 'index']);
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::post('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'save']);
Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);


Route::get('/holidays', [OfficialHolidayController::class, 'getHolidays']);
