<?php

namespace App\Http\Controllers;
use Illuminate\Http\Request;
use App\Models\User;

class StatisticsController extends Controller{

    public function index()
    {

        $users = User::all();

        return view('statistics.index',compact('users'));
    }

}
