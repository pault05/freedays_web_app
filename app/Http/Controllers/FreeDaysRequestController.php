<?php

namespace App\Http\Controllers;

use App\Models\FreeDaysRequest;
use App\Http\Requests\StoreFree_days_requestsRequest;
use App\Http\Requests\UpdateFree_days_requestsRequest;

class FreeDaysRequestController extends Controller
{
    public function index()
    {
        return view('free_day_request');
    }

    public function save()
    {
        dd(request()->all());
    }

    public function getFreeDays()
    {
        $freeDays = FreeDaysRequest::all()->map(function($freeDays) {
            return $freeDays->only(['user_id', 'starting_date', 'ending_date']); //TODO: user_name
        });
        return response()->json($freeDays);
    }
}
