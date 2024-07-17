<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// acc creation serban din post in get
Route::post('/account-creation', function ()
{
    return view('account_creation');
});

// user profile edina
Route::get('/user-profile', function ()
{
    return view('user_profile');
});

// holiday req georgiana
Route::post('/free-day-request', function ()
{
   return view('free_day_request');
});

// admin view on hol req
Route::get('/admin-view', function ()
{
    return view('admin_view');
});

// home page paul   / sau /home
Route::get('/home', function ()
{
    return view('home');
});

// login tudor
Route::post('/login', function ()
{
    return view('login');
});
