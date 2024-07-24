<?php

namespace App\Http\Controllers;
use App\Models\FreeDaysRequest;
use Illuminate\Http\Request;
use App\Models\User;

class StatisticsController extends Controller{

    public function index()
    {
        $userId = auth()->user()->id;
        $freeDaysRequests = FreeDaysRequest::where('user_id', $userId)->get();
        //dd($freeDaysRequests);
        //$users = User::all();

        $requestsByDescription = $freeDaysRequests->groupBy('description')->map(function($item,$key){
            return $item->count();
        });

        //dd($requestsByDescription);

        return view('statistics',compact('requestsByDescription'));
    }

}
