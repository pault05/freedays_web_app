<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class LoginController extends Controller
{
    // login tudor
    public function index(Request $request)
    {
        return view('login');

    }

}
