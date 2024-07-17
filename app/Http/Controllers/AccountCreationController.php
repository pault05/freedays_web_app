<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class AccountCreationController extends Controller
{
    // acc creation serban din post in get
    public function index()
    {
        return view('account_creation');
    }
}
