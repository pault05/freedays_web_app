<?php

namespace App\Http\Controllers;

use App\Mail\FreeDayRequestMail;
use App\Models\File;
use App\Models\FreeDaysReqFile;
use App\Models\FreeDaysRequest;
use App\Models\OfficialHoliday;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Http\Controllers\OfficialHolidayController;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Storage;
use App\Models\Category;
use Illuminate\Support\Facades\DB;


class FreeDaysRequestController extends Controller
{
    public function index(Request $request) {
        $user = Auth::user();

        $approved = 0;
        if (isset($user->freeDays) && count($user->freeDays)) {
            foreach ($user->freeDays as $day) {
                if ($day->status == 'Approved' && $day->category->is_subtractable == 1) {
                    if ($day->half_day) {
                        $approved += 0.5;
                    } else {
                        $approved += $day->days;
                    }

                }
            }
        }

        $categories = Category::all();

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

        return view('free_day_request', compact('request_leave', 'categories'));
    }


    public function save(Request $request){
    // Validation logic here (if any)

        $user = Auth::user();
        $user_id = $user->id;
        $user_admin = $user->is_admin;

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

        $user_mail = $user->email;
        $user_company_id = $user->company_id;

        $admins = DB::table('users')
        ->where('is_admin', 1)
        ->where('company_id', $user_company_id)
        ->pluck('email')->toArray();

        Mail::to($user_mail)->cc($admins)->send(new FreeDayRequestMail($freeDayRequest, $user));

        return redirect()->back()->with('success', 'The request has been sent successfully!');
    }


    public function getFreeDays()
    {
        if (Auth::user()->is_admin) {

            $adminCompanyId = Auth::user()->company_id;

            $freeDays = FreeDaysRequest::whereHas('user', function ($query) use ($adminCompanyId) {
                $query->where('company_id', $adminCompanyId);
            })->get()->map(function ($freeDays) {
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
