<?php

namespace App\Http\Controllers;
use App\Models\FreeDaysRequest;
use Illuminate\Http\Request;
use App\Models\User;
use Carbon\Carbon;

class StatisticsController extends Controller{

    public function index()
    {
        $userId = auth()->user()->id;
        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)->get();
        //dd($freeDaysRequests);
        //$users = User::all();
        $allFreeDays = FreeDaysRequest::get();

        $daysInYear = FreeDaysRequest::whereYear('starting_date', '=', Carbon::now()->year)->get();

        $freeDaysArray = array();
        $days = 0;
        foreach ($allFreeDays as $request) {
            //dd($request);
            $year = Carbon::parse($request['starting_date'])->year;
            //$days += $freeDaysRequests['days'];
            $days += $request['days'];
        }
        //$freeDaysArray['year'] = $year;
        //$freeDaysArray['days'] = $days;
        $freeDaysArray = array (
            array("2023",22),
            array("2024",15),
            array("2025",5),
            array("2026",17)
        );
        $data = $freeDaysRequests->map(function ($request){
            $start = Carbon::parse($request->starting_date);
            $end = Carbon::parse($request->ending_date);
            $daysOff = $end->diffInDays($start) + 1;

            return[
                'month' => $start->format('F Y'),
                'days' => $daysOff,
            ];
        });

        $statistics = $data->groupBy('month')->map(function ($items){
            return $items->sum('days');
        });

        $requestsByDescription = $freeDaysRequests->groupBy('description')->map(function($item,$key){
            return $item->count();
        });

        $charData = $requestsByDescription->map(function ($count, $description){
            return [$description, $count];
        })->values()->toArray();

        return view('statistics',[
            'statistics' => $statistics,
            'requestsByDescription' => $requestsByDescription,
            'charData' => $charData,
            'daysPerYear' => $freeDaysArray
        ]);

        //dd($requestsByDescription);

        //return view('statistics',compact('requestsByDescription'));
    }

}
