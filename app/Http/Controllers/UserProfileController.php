<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;

class UserProfileController extends Controller
{
    public function index()
    {
        $first_name= Auth::user()->first_name;
        $last_name= Auth::user()->last_name;
        $email= Auth::user()->email;
        $phone= Auth::user()->phone;
        $free_days= Auth::user()->free_days;
        $hired_at= Auth::user()->hired_at;
        $color=Auth::user()->color;
        $position=Auth::user()->position;

        $user = [
            'first_name' =>$first_name,
            'last_name' => $last_name,
            'email' => $email,
            'phone' => $phone,
            'days_off_left' => $free_days,
            'hired_at' => $hired_at,
            'color' => $color,
            'position' => $position,
        ];

        return view('user_profile', compact('user'));
    }

    public function save(Request $request){
//        $request->validate([
//            'first_name' => 'required|string|max:255',
//            'last_name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
//            'phone' => 'nullable|string|max:20',
//        ]);

//        dd($request->all());
        // Preluarea datelor
        $first_name = $request->input('first_name');
        $last_name = $request->input('last_name');
        $email = $request->input('email');
        $phone = $request->input('phone');
        $color = $request->input('selected_color');

        // Afișarea datelor pentru debugging
//        dd($request->all());

        // Preluarea utilizatorului autentificat
        $user = Auth::user();

        // Actualizarea atributelor
        $user->first_name = $first_name;
        $user->last_name = $last_name;
        $user->email = $email;
        $user->phone = $phone;
        $user->color = $color;

        // Salvarea modificărilor
        $user->save();

        // Redirecționarea
        return redirect('/user-profile');
    }

    public function changePassword(Request $request){
        $user = Auth::user();
//        dd($request->all());
        if (!Hash::check($request->input('current_password'), $user->password)) {
            return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
        }
        else{
            if ($request->input('new_password') == $request->input('current_password')) {
                return redirect()->back()->withErrors(['new_password' => 'The new password cannot be the same as current password.']);
            }
            else{
                $user->password = Hash::make($request->input('new_password'));
                $user->save();
                return redirect()->back()->with('status', 'Password changed successfully!');
            }


        }

    }
}
