<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AccountCreationController extends Controller
{
    // acc creation serban din post in get
    public function index()
    {
        return view('account_creation');
    }

    public function store(Request $request){
//            dd($request->all());
            $first_name = $request->input('first_name');
            $last_name = $request->input('last_name');
            $email = $request->input('email');
            $position = $request->input('position');
            $phone = $request->input('phone');
            $company_id = Auth::user()->company_id;
            $free_days = $request->input('free_days');
            $hired_at = $request->input('hired_at');
            $password = $request->input('password');
            $is_admin = $request->role_text === 'Admin';

            $user = new User();
            $user->create([
                'first_name' => $first_name,
                'last_name' => $last_name,
                'email' => $email,
                'position' => $position,
                'phone' => $phone,
                'is_admin' => $is_admin,
                'company_id' => $company_id,
                'free_days' => $free_days,
                'created_at' => now(),
                'updated_at' => now(),
                'hired_at' => $hired_at,
                'password' => $password,
                'deleted_at' => null,
                'color' => fake()->randomElement([
                    '#FF5733', '#33FF57', '#3357FF', '#FF33A1', '#A1FF33', '#33A1FF',
                    '#FF3380', '#80FF33', '#3380FF', '#FF8333', '#33FF83', '#8333FF',
                    '#FF3333', '#33FF33', '#3333FF']),
            ]);
        return redirect('/admin-view-user');
    }
}
