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
        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)->with('category')->get();
        //dd($freeDaysRequests);
        //$users = User::all();
        $allFreeDays = FreeDaysRequest::with('category')->get();
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
            array("2027",22),
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

        $requestsByDescription = $freeDaysRequests->groupBy('category.name')->map(function($item,$key){
            return $item->count();
        });

        $charData = $requestsByDescription->map(function ($count, $category_name){
            return [$category_name, $count];
        })->values()->toArray();

//        $daysPerMonth = $data->groupBy(function($item){
//            return Carbon::parse($item['month'])->format('F');
//        })->map(function ($item){
//            return $item->sum('days');
//        });

        $daysPerMonth = $freeDaysRequests->map(function ($request) {
            $start = Carbon::parse($request->starting_date);
            $end = Carbon::parse($request->ending_date);
            $daysOff = $end->diffInDays($start) + 1;

            return [
                'month' => $start->format('F'),
                'days' => $daysOff,
            ];
        })->groupBy('month')->map(function ($items) {
            return $items->sum('days');
        });

        // Ensure all months are present
        $months = collect(['January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December']);
        $daysPerMonth = $months->mapWithKeys(function ($month) use ($daysPerMonth) {
            return [$month => $daysPerMonth->get($month, 0)];
        });

        return view('statistics',[
            'statistics' => $statistics,
            'requestsByDescription' => $requestsByDescription,
            'charData' => $charData,
            'daysPerYear' => $freeDaysArray,
            'daysPerMonth' => $daysPerMonth

        ]);

        //dd($requestsByDescription);

        //return view('statistics',compact('requestsByDescription'));
    }

}
