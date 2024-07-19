<?php

use App\Http\Controllers\FreeDaysRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\OfficialHolidayController;

Route::get('/home', function () {
    return view('home');
});


Route::get('/free-day-request', [\App\Http\Controllers\FreeDaysRequestController::class, 'index']);
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);

Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::post('/admin-view/approve/{id}', [AdminViewController::class, 'approve'])->name('admin-view.approve');
Route::post('/admin-view/deny/{id}', [AdminViewController::class, 'deny'])->name('admin-view.deny');


Route::post('/login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);

Route::get('/official-holiday', [OfficialHolidayController::class, 'index'])->name('official-holiday.index');
Route::post('/official-holiday', [\App\Http\Controllers\OfficialHolidayController::class, 'store'])->name('official-holiday.store');

Route::get('/holidays', [OfficialHolidayController::class, 'getHolidays']);
