<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FreeDaysRequest;
use App\Http\Requests\StoreFree_days_requestsRequest;
use App\Http\Requests\UpdateFree_days_requestsRequest;
use App\Models\OfficialHoliday;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OfficialHolidayController;

class FreeDaysRequestController extends Controller
{
    public function index(Request $request)
    {

        $user_id = $request->input('user_id');
        $category_id = $request->input('category_id');
        $status = $request->input('status');
        $starting_date = $request->input('starting_date');
        $ending_date = $request->input('ending_date');
        $half_day = $request->input('half_day');
        $description = $request->input('description');
        $user = Auth::user();


        //dd($user->freeDays);
        $approved = 0;
        if (isset($user->freeDays) && count($user->freeDays)) {
            foreach ($user->freeDays as $day) {
                if ($day->status == 'Approved') {
                    $approved += $day->days;
                }
            }
        }
        $request_leave = [
            'user_id' => $user_id,
            'category_id' => $category_id,
            'status' => $status,
            'starting_date' => $starting_date,
            'ending_date' => $ending_date,
            'half_day' => $half_day,
            'description ' => $description,
            'approved' => $approved
        ];
        return view('free_day_request', compact('request_leave'));
    }

    public function save(Request $request)
    {
        $request->validate([
            'category_id' => 'required|integer',
            'start-date' => 'required|date',
            'end-date' => 'required|date|after_or_equal:start-date',
            'half-day' => 'nullable|boolean',
            'days' => 'required|integer',
            'description' => 'nullable|string|max:255',
        ]);

        $category_id = $request->input('category_id');
        $starting_date = $request->input('start-date');
        $ending_date = $request->input('end-date');
        $half_day = $request->input('half-day') ? 1 : 0;
        $days = $request->input('days');
        $description = $request->input('description');

        $user = Auth::user();
        $user_id = $user->id;

        $freeDayRequest = new FreeDaysRequest();
        $freeDayRequest->user_id = $user_id;
        $freeDayRequest->category_id = $category_id;
        $freeDayRequest->starting_date = $starting_date;
        $freeDayRequest->ending_date = $ending_date;
        $freeDayRequest->half_day = $half_day;
        $freeDayRequest->days = $days;
        $freeDayRequest->description = $description;
        $freeDayRequest->save();

//        $file = $request->file('proof');
//        dd($file);

        return redirect()->back()->with('success', 'Cererea a fost trimisa cu succes!');
    }

    public function getFreeDays()
    {
        if (Auth::user()->is_admin) {
            $freeDays = FreeDaysRequest::all()->map(function ($freeDays) {
                return $freeDays->only(['user_id', 'starting_date', 'ending_date', 'status']);
            });
        } else {
            $currentUserId = Auth::id();
            $freeDays = FreeDaysRequest::where('user_id', $currentUserId)->get()->map(function ($freeDays) {
                return $freeDays->only(['user_id', 'starting_date', 'ending_date', 'status']);
            });
        }

        $users = User::all()->mapWithKeys(function ($user) {
            return [$user->id => [
                'name' => $user->first_name . ' ' . $user->last_name,
                'color' => $user->color,
                'is_admin' => $user->is_admin,
            ]];
        });

        $freeDaysWithUserDetails = $freeDays->map(function ($freeDays) use ($users) {
            $userId = $freeDays['user_id'];
            $userDetails = $users[$userId] ?? ['name' => 'Unknown', 'color' => '#CEE65A'];
            return array_merge($freeDays, [
                'employee_name' => $userDetails['name'],
                'color' => $userDetails['color'],
                'is_admin' => $userDetails['is_admin'],
            ]);
        });

        return response()->json($freeDaysWithUserDetails);
    }
}



/*
 public function getFreeDays()
    {
        if (Auth::user()->is_admin) {
            $freeDays = FreeDaysRequest::all()->map(function ($freeDays) {
                return $freeDays->only(['user_id', 'starting_date', 'ending_date', 'status']);
            });

            $users = User::all()->mapWithKeys(function ($user) {
                return [$user->id => [
                    'name' => $user->first_name . ' ' . $user->last_name,
                    'color' => $user->color,
                    'is_admin' => $user->is_admin,
                ]];
            });

            $freeDaysWithUserDetails = $freeDays->map(function ($freeDays) use ($users) {
                $userId = $freeDays['user_id'];
                $userDetails = $users[$userId] ?? ['name' => 'Unknown', 'color' => '#CEE65A'];
                return array_merge($freeDays, [
                    'employee_name' => $userDetails['name'],
                    'color' => $userDetails['color'],
                    'is_admin' => $userDetails['is_admin'],
                ]);
            });

            return response()->json($freeDaysWithUserDetails);
        }
        else
        {
            $holidays = OfficialHoliday::all()->map(function ($holiday) {
                return $holiday->only(['name', 'date']);
            });
            return response()->json($holidays);
        }
    }
 */


/*
  public function save(Request $request)
    {
        // Preluarea datelor
        $category_id = $request->input('category_id');
        $starting_date = $request->input('start-date');
        $ending_date = $request->input('end-date');
        $half_day = ($request->input('half-day')) ? 1 : 0;
        $days = $request->input('days');
        $description = $request->input('description');

        //preluam utilizatorul autentificat
        $user = Auth::user();
        $user_id = $user->id;

        $freeDayRequest = new FreeDaysRequest();
        $freeDayRequest->user_id = $user_id;
        $freeDayRequest->category_id = $category_id;
        $freeDayRequest->starting_date = $starting_date;
        $freeDayRequest->ending_date = $ending_date;
        $freeDayRequest->half_day = $half_day;
        $freeDayRequest->days = $days;
        $freeDayRequest->description = $description;

        // Salvam cererea în baza de date
        $freeDayRequest->save();

        return redirect()->back()->with('success', 'Cererea a fost trimisa cu succes!');
    }
 */
