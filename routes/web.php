<?php

use App\Http\Controllers\FreeDaysRequestController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\AdminViewController;
use App\Http\Controllers\OfficialHolidayController;

Route::get('/home', function () {
    return view('home');
});

Route::middleware(['auth', 'admin'])->group(function () {
    Route::get('/account-creation', [AccountCreationController::class, 'index']);
    Route::post('/account-creation', [AccountCreationController::class, 'store']);

Route::get('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'index']);
Route::post('/account-creation', [\App\Http\Controllers\AccountCreationController::class, 'store']);

Route::get('/admin-view', [\App\Http\Controllers\AdminViewController::class, 'index'])->name('admin-view.index');
Route::post('/admin-view/approve/{id}', [AdminViewController::class, 'approve'])->name('admin-view.approve');
Route::post('/admin-view/deny/{id}', [AdminViewController::class, 'deny'])->name('admin-view.deny');
Route::get('/admin-view/search', [AdminViewController::class, 'search'])->name('admin-view.search');
Route::get('/admin-view/filter', [AdminViewController::class, 'filter'])->name('admin-view.filter');
//Route::get('admin-view/sort', [AdminViewController::class, 'sort'])->name('admin-view.sort');
//Route::get('admin-view/sortByStatus', [AdminViewController::class, 'sortByStatus'])->name('admin-view.sortByStatus');  //rezolvat, am mutat tot in index

    Route::get('/official-holiday', [OfficialHolidayController::class, 'index'])->name('official-holiday.index');
    Route::post('/official-holiday', [OfficialHolidayController::class, 'store'])->name('official-holiday.store');
    Route::delete('/official-holiday/deleteAll', [OfficialHolidayController::class, 'deleteAll'])->name('official-holiday.deleteAll');
    Route::delete('/official-holiday/destroy/{id}', [OfficialHolidayController::class, 'destroy'])->name('official-holiday.destroy');

});

Route::get('/free-day-request', [FreeDaysRequestController::class, 'index'])->name('free_day_request');
Route::post('/free-day-request/save', [FreeDaysRequestController::class, 'save']);
Route::get('/free-day-request', [FreeDaysRequestController::class, 'index']);
Route::post('/free-day-request', [FreeDaysRequestController::class, 'save']);
Route::get('/free-days-request-json', [FreeDaysRequestController::class, 'getFreeDays']);

Route::get('/login', [LoginController::class, 'create'])->name('login');
Route::post('/login', [LoginController::class, 'store']);
Route::get('/logout', [LoginController::class, 'logout'])->name('logout');

Route::get('/user-profile', [UserProfileController::class, 'index']);
Route::post('/user-profile', [UserProfileController::class, 'save']);
Route::post('/user-profile/change-password', [UserProfileController::class, 'changePassword']);

Route::get('/holidays', [OfficialHolidayController::class, 'getHolidays']);

Route::get('/statistics',[StatisticsController::class,'index'])->name('statistics');

