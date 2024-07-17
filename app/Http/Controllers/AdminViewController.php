<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminView;
use App\Models\FreeDaysRequest;

class AdminViewController extends Controller
{
    // admin view on hol req
    public function index()
    {
        $adminView = FreeDaysRequest::all();
        return view('admin_view', ['adminView' => $adminView]);
    }
}
