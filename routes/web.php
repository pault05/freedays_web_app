<?php


use App\Http\Controllers\UserProfileController;
use App\Http\Controllers\FreeDaysRequestController;
use App\Http\Controllers\OfficialHolidayController;
use App\Http\Controllers\AccountCreationController;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\LoginController;
use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});


Route::get('/free-day-request', [FreeDaysRequestController::class, 'index']);
Route::post('/free-day-request/save', [FreeDaysRequestController::class, 'save'])->name('save');
Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::post('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'save']);
Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index']);
Route::post('/login', [\App\Http\Controllers\LoginController::class, 'index']);
Route::get('/user-profile', [\App\Http\Controllers\UserProfileController::class, 'index'])->name('user.profile');

<<<<<<< Updated upstream

Route::get('/holidays', [OfficialHolidayController::class, 'getHolidays']);
=======
>>>>>>> Stashed changes
