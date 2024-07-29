<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Models\FreeDaysReqFile;
use App\Models\FreeDaysRequest;
use App\Models\OfficialHoliday;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OfficialHolidayController;
use Illuminate\Support\Facades\Storage;

class FreeDaysRequestController extends Controller
{
    public function index(Request $request){
        $user = Auth::user();

        $approved = 0;
        if (isset($user->freeDays) && count($user->freeDays)) {
            foreach ($user->freeDays as $day) {
                if ($day->status == 'Approved') {
                    $approved += $day->days;
                }
            }
        }

        $request_leave = [
            'user_id' => $request->input('user_id'),
            'category_id' => $request->input('category_id'),
            'status' => $request->input('status'),
            'starting_date' => $request->input('starting_date'),
            'ending_date' => $request->input('ending_date'),
            'half_day' => $request->input('half_day'),
            'description' => $request->input('description'),
            'approved' => $approved
        ];

      return view('free_day_request', compact('request_leave'));
    }


    public function save(Request $request){
    // Validation logic here (if any)

        $user = Auth::user();
        $user_id = $user->id;

        $freeDayRequest = new FreeDaysRequest([
            'user_id' => $user_id,
            'category_id' => $request->input('category_id'),
            'starting_date' => $request->input('start-date'),
            'ending_date' => $request->input('end-date'),
            'half_day' => $request->input('half-day') ? 1 : 0,
            'days' => $request->input('days'),
            'description' => $request->input('description')
        ]);

        $freeDayRequest->save();

        //salvam fisierul
        if ($request->file('proof')) {
            $path = $request->file('proof')->store('uploads', 'public');
            $file = File::create([
              //  'name' => $request->file('proof')->getClientOriginalName(),
                'ext' => $request->file('proof')->getClientOriginalExtension(),
             //   'path' => $path,
            ]);

            $file->path = $file->id . '.' . $file->ext;
            $file->save();

            $freeDayRequestFile = new FreeDaysReqFile();
            $freeDayRequestFile->file_id = $file->id;
            $freeDayRequestFile->free_day_req_id = $freeDayRequest->id;
            $freeDayRequestFile->save();
        }

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
