<?php
namespace App\Http\Controllers;
use Illuminate\Http\Request;

class AdminStatisticsController extends Controller{
    public function index(){
        return view('admin_statistics');
    }
}
