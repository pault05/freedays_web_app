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
use App\Mail\FreeDayStatusMail;
use Yajra\DataTables\DataTables;


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

        $daysOffLeft = 21 - $approved;

        return view('free_day_request', compact('request_leave', 'categories', 'daysOffLeft'));
    }

    public function userRequests(){
        $userId = auth()->user()->id;

        $requests = FreeDaysRequest::with('category')->where('user_id', $userId)->get();

        $categories = Category::all();
        $statuses = FreeDaysRequest::distinct()->pluck('status');

        return view('user_view', compact('requests', 'categories', 'statuses'));
    }

    public function getData(Request $request){
        $userId = auth()->user()->id;

        $query = FreeDaysRequest::with('category')->where('user_id', $userId);

        $dataTables = DataTables::of($query);

        return $dataTables
            ->filter(function($query) use ($request){
                $searchValue = $request->input('search.value');
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('description', 'like', "%$searchValue%");
                    });
                }
            })
            ->addColumn('starting_date', function ($request){
                return $request->starting_date;
            })
            ->orderColumn('starting_date', function($query, $order){
                $query->orderBy('starting_date', $order);
            })
            ->addColumn('ending_date', function ($request){
                return $request->ending_date;
            })
            ->orderColumn('ending_date', function($query, $order){
                $query->orderBy('ending_date', $order);
            })
            ->addColumn('description', function ($request){
                return $request->description;
            })
            ->orderColumn('description', function($query, $order){
                $query->orderBy('description', $order);
            })
            ->addColumn('category_name', function ($request){
                return $request->category->name;
            })
            ->orderColumn('category_name', function($query, $order) {
                $query->join('categories', 'free_days_requests.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $order);
            })
            ->addColumn('status', function ($request){
                return $request->status;
            })
            ->orderColumn('status', function($query, $order){
                $query->orderBy('status', $order);
            })
            ->filterColumn('category_name', function($query, $keyword){
                $query->whereHas('category', function($q) use ($keyword){
                    $q->where('id', $keyword);
                });
            })
            ->filterColumn('status', function($query, $keyword){
                $query->where('status', $keyword);
            })
            ->addColumn('actions', function($request){
                $extraButton = '<a href="' . route('free-day-edit', ['id' => $request->id]) . '" class="btn btn-edit btn-sm" id="btnEdit" style="border: none; background-color: transparent">
                                     <img src="https://img.icons8.com/?size=100&id=6697&format=png&color=228BE6" alt="" style="width: 30px; border: none; background-color: transparent" class="action-icons">
                                 </a>';
                return '<div style="display: flex; align-items: center;">' . $extraButton . '</div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }


    public function save(Request $request){

        $validatedData = $request->validate([
            'category_id' => 'required|exists:categories,id',
            'start-date' => 'required|date|after_or_equal:today',
            'end-date' => 'required|date|after_or_equal:start-date',
            'half-day' => 'nullable|boolean',
            'days' => 'required|numeric|min:1',
            'description' => 'nullable|string|max:100',
            'proof' => 'nullable|file|mimes:jpg,png,pdf|max:5000'
        ]);

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

       // $user_mail = $user->email;
        $user_company_id = $user->company_id;

        $admins = DB::table('users')
        ->where('is_admin', 1)
        ->where('company_id', $user_company_id)
            ->where('email', '<>', auth()->user()->email) // excludem utilizatorul curent
            ->get();

        foreach($admins as $admin) {
            Mail::to($admin->email)->send(new FreeDayRequestMail($freeDayRequest, $admin, $user));
        }

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
