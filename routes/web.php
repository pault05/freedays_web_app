<?php

use App\Http\Controllers\FreeDaysRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\OfficialHolidayController;

Route::get('/home', function () {
    return view('home');
});


Route::get('/free-day-request', [\App\Http\Controllers\FreeDaysRequestController::class, 'index']);
Route::post('/free-day-request', [FreeDaysRequestController::class, 'save']);
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::post('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'store']);

Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::post('/admin-view/approve/{id}', [AdminViewController::class, 'approve'])->name('admin-view.approve');
Route::post('/admin-view/deny/{id}', [AdminViewController::class, 'deny'])->name('admin-view.deny');


Route::get('/login', [\App\Http\Controllers\LoginController::class, 'create'])->name('login');
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'store']);

Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index']);
Route::post('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'save']);

Route::get('/official-holiday', [OfficialHolidayController::class, 'index'])->name('official-holiday.index');
Route::post('/official-holiday', [\App\Http\Controllers\OfficialHolidayController::class, 'store'])->name('official-holiday.store');

Route::delete('/official-holiday/deleteAll', [\App\Http\Controllers\OfficialHolidayController::class, 'deleteAll'])->name('official-holiday.deleteAll');
Route::delete('/official-holiday/destroy/{id}', [\App\Http\Controllers\OfficialHolidayController::class, 'destroy'])->name('official-holiday.destroy');

Route::get('/holidays', [OfficialHolidayController::class, 'getHolidays']);
Route::get('/free-days-request-json', [FreeDaysRequestController::class, 'getFreeDays']);
