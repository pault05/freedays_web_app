<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;

class AccountCreationController extends Controller
{
    // acc creation serban din post in get
    public function index()
    {
        return view('account_creation');
    }

    public function create(){
//        User::create([
//            'first_name'=>request('first_name'),
//            'last_name'=>request('last_name'),
//            'email',
//            'email_verified_at',
//            'position',
//            'phone',
//            'is_admin',
//            'company_id',
//            'free_days',
//            'created_at',
//            'updated_at',
//            'hired_at',
//            'password',
//            'deleted_at'
//        ])
        dd(request()->all());
    }
}
