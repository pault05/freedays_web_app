<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AdminViewController extends Controller
{
    // admin view on hol req
    public function index()
    {
        return view('admin_view');
    }

}
