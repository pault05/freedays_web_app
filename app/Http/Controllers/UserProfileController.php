<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class UserProfileController extends Controller
{
    // user profile edina
    public function index()
    {
        return view('user_profile');
    }
}
