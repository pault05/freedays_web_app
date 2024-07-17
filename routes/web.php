<?php

use Illuminate\Support\Facades\Route;

Route::get('/', function () {
    return view('welcome');
});

// acc creation serban din post in get
Route::post('/accountCreation', function ()
{
    return view('account-creation');
});

// user profile edina
Route::get('/userProfile', function ()
{
    return view('user-profile');
});

// holiday req georgiana
Route::post('/holidayRequest', function ()
{
   return view('holiday-request');
});

// admin view on hol req
Route::get('/adminView', function ()
{
    return view('admin-view');
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
