<?php

namespace App\Http\Controllers;

use App\Models\FreeDaysRequest;
use App\Http\Requests\StoreFree_days_requestsRequest;
use App\Http\Requests\UpdateFree_days_requestsRequest;
use App\Models\User;

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
            return $freeDays->only(['user_id', 'starting_date', 'ending_date']);
        });

        $users = User::all()->mapWithKeys(function($user) {
            return [$user->id => $user->first_name . ' ' . $user->last_name];
        });

        $freeDaysWithUserNames = $freeDays->map(function($freeDays) use ($users) {
           $userId = $freeDays['user_id'];
           $userName = $users[$userId] ?? 'Unknown';
           return array_merge($freeDays, ['employee_name' => $userName]);
        });

        return response()->json($freeDaysWithUserNames);
    }
}
