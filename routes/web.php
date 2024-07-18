<?php

use App\Http\Controllers\FreeDayRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminViewController;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/free-day-request', [\App\Http\Controllers\FreeDaysRequestController::class, 'index']);
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);

Route::get('/official-holiday', [\App\Http\Controllers\OfficialHolidayController::class, 'index']);






