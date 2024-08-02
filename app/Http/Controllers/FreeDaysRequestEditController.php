<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreeDaysRequestEditController extends Controller
{
    public function index()
    {
        return view('free_days_request');
    }
}
