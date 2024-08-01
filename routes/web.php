<?php

use App\Http\Controllers\AccountCreationController;
use App\Http\Controllers\AdminViewUserController;
use App\Http\Controllers\AdminStatisticsController;
use App\Http\Controllers\FreeDaysRequestController;
use App\Http\Controllers\LoginController;
use App\Http\Controllers\StatisticsController;
use App\Http\Controllers\UserProfileController;
use App\Mail\FreeDayRequest;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\OfficialHolidayController;

Route::get('/', function () {
    return view('login');
});
Route::middleware(['back'])->group(function () {
Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
});
Route::middleware(['auth', 'admin', 'back'])->group(function () {
    Route::get('/account-creation', [AccountCreationController::class, 'index']);
    Route::post('/account-creation', [AccountCreationController::class, 'store']);

    Route::get('/admin-view', [AdminViewController::class, 'index'])->name('admin-view.index');
    Route::get('/admin-view/approve/{id}', [AdminViewController::class, 'approve'])->name('admin-view.approve');
    Route::get('/admin-view/deny/{id}', [AdminViewController::class, 'deny'])->name('admin-view.deny');
    Route::post('/admin-view/data', [AdminViewController::class, 'getData'])->name('admin-view.data');
//    Route::get('/admin-view/search', [AdminViewController::class, 'search'])->name('admin-view.search');
//    Route::get('/admin-view/filter', [AdminViewController::class, 'filter'])->name('admin-view.filter');

    Route::get('/admin-view-user', [AdminViewUserController::class, 'index'])->name('admin-view-user.index');
    Route::delete('/admin-view-user/delete/{id}', [AdminViewUserController::class, 'delete'])->name('admin-view-user.delete');

    Route::get('/official-holiday', [OfficialHolidayController::class, 'index'])->name('official-holiday.index');
    Route::post('/official-holiday', [OfficialHolidayController::class, 'store'])->name('official-holiday.store');
    Route::delete('/official-holiday/deleteAll', [OfficialHolidayController::class, 'deleteAll'])->name('official-holiday.deleteAll');
    Route::delete('/official-holiday/destroy/{id}', [OfficialHolidayController::class, 'destroy'])->name('official-holiday.destroy');
    Route::get('/official-holiday/data', [OfficialHolidayController::class, 'getData'])->name('official-holiday.data');

    Route::get('/admin-statistics', [AdminStatisticsController::class, 'index'])->name('admin-statistics');

});


Route::middleware(['auth', 'back'])->group(function () {
    Route::get('/free-day-request', [FreeDaysRequestController::class, 'index'])->name('free_day_request');
    Route::post('/free-day-request/save', [FreeDaysRequestController::class, 'save']);
    Route::get('/free-day-request', [FreeDaysRequestController::class, 'index']);
    Route::post('/free-day-request', [FreeDaysRequestController::class, 'save']);
    Route::get('/free-days-request-json', [FreeDaysRequestController::class, 'getFreeDays']);

    Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

    Route::get('/user-profile/{id}', [UserProfileController::class, 'index'])->name('user-profile');
    Route::post('/user-profile/{id}', [UserProfileController::class, 'save'])->name('user-profile.save');
    Route::post('/user-profile/change-password/{id}', [UserProfileController::class, 'changePassword'])->name('user-profile.change-password');

    Route::get('/holidays', [OfficialHolidayController::class, 'getHolidays'])->name('sarbatoare');

    Route::get('/statistics',[StatisticsController::class,'index'])->name('statistics');

    Route::get('/home', function () {
        return view('home');
    });

});


