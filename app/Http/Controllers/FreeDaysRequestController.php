<?php

namespace App\Http\Controllers;

use App\Models\FreeDaysRequest;
use App\Http\Requests\StoreFree_days_requestsRequest;
use App\Http\Requests\UpdateFree_days_requestsRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FreeDaysRequestController extends Controller
{
    public function index(Request $request)
    {

        $user_id = $request->input('user_id');
        $category_id = $request->input('category_id');
        $status  = $request->input('status');
        $starting_date = $request->input('starting_date');
        $ending_date = $request->input('ending_date');
        $half_day = $request->input('half_day');
        $description = $request->input('description');

        $request_leave = [
            'user_id' => $user_id,
            'category_id' => $category_id,
            'status' => $status,
            'starting_date' => $starting_date,
            'ending_date' => $ending_date,
            'half_day' => $half_day,
            'description '=> $description,

        ];
        return view('free_day_request');
    }

    public function save(request $request)
    {
        //dd($request->all());
        //preluarea datelor
        $category_id = $request->input('category_id');
        //$status = $request->input('status');
        $starting_date = $request->input('start-date');
        $ending_date = $request->input('end-date');
        $half_day = ($request->input('half-day')) ? 1 : 0;
        $description = $request->input('description');


        $user = Auth::user();

        $user_id = $user->id;

        $freeDayRequest = new FreeDaysRequest();
        $freeDayRequest->user_id = $user_id;
        $freeDayRequest->category_id = $category_id;
        //$freeDayRequest->status = $status;
        $freeDayRequest->starting_date = $starting_date;
        $freeDayRequest->ending_date = $ending_date;
        $freeDayRequest->half_day = $half_day;
        $freeDayRequest->description = $description;

        //salvam cererea in baza de date
        $freeDayRequest->save();



        return redirect()->back()->with('success', 'Cererea a fost trimisa cu succes!');

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
