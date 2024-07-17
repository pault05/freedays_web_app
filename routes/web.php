<?php

use App\Http\Controllers\FreeDaysRequestController;
use Illuminate\Support\Facades\Route;

Route::get('/home', function () {
    return view('home');
});


Route::get('/free-day-request', [FreeDaysRequestController::class, 'index']);
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);
