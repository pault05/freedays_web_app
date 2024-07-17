<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class FreeDayRequestController extends Controller
{
    // holiday req georgiana

    public function index(Request $request)
    {
        return view('free_day_request');
    }
}
