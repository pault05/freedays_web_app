<?php

namespace App\Http\Controllers;

use App\Models\FreeDaysRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use League\CommonMark\Node\Inline\AbstractInline;

class UserProfileController extends Controller
{
    public function index($id)
    {
//        $request = User::findOrFail($id);
////        dd(Auth::user()->hired_at);
//        $first_name= $request->first_name;
//        $last_name= $request->last_name;
//        $email= $request->email;
//        $phone= $request->phone;
//        $free_days= $request->free_days;
//        $hired_at= $request->hired_at;
//        $color=$request->color;
//        $position=$request->position;
//
//        $user = [
//            'first_name' =>$first_name,
//            'last_name' => $last_name,
//            'email' => $email,
//            'phone' => $phone,
//            'free_days' => $free_days,
//            'hired_at' => $hired_at,
//            'color' => $color,
//            'position' => $position,
//        ];

        $user = User::findOrFail($id);

        return view('user_profile', ['user' => $user]);
    }

    public function save(Request $request,$id){
////        $request->validate([
////            'first_name' => 'required|string|max:255',
////            'last_name' => 'required|string|max:255',
////            'email' => 'required|string|email|max:255|unique:users,email,' . Auth::id(),
////            'phone' => 'nullable|string|max:20',
////        ]);
//        // Preluarea utilizatorului autentificat
//        $user = Auth::user();
//
////        dd($request->all());
//        // Preluarea datelor
//        $first_name = $request->input('first_name');
//        $last_name = $request->input('last_name');
//        $email = $request->input('email');
//        $phone = $request->input('phone');
//        $color = $request->input('selected_color');
//        if($user->is_admin){
//            $position = $request->input('position');
//            $free_days= $request->input('free_days');
//        }
//
//        // Afișarea datelor pentru debugging
//        dd($request->all())
//
//
//
//        // Actualizarea atributelor
//        $user->first_name = $first_name;
//        $user->last_name = $last_name;
//        $user->email = $email;
//        $user->phone = $phone;
//        $user->color = $color;
//        if($user->is_admin)
//        {
//            $user->position = $position;
//            $user->free_days = $free_days;
//        }
//
//        // Salvarea modificărilor
//        $user->save();
//
//        // Redirecționarea
//        return redirect('/user-profile');

            // Validarea datelor primite
        $request->validate([
            'first_name' => 'required|string|max:255',
            'last_name' => 'required|string|max:255',
            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
            'phone' => 'nullable|string|max:20',
            'selected_color' => 'nullable|string|max:7',
            'position' => 'nullable|string|max:255', // Doar pentru admini
            'free_days' => 'nullable|integer|min:0' // Doar pentru admini
        ]);

        // Preluarea utilizatorului
        $user = User::findOrFail($id);

        // Actualizarea atributelor
        $user->first_name = $request->input('first_name');
        $user->last_name = $request->input('last_name');
        $user->email = $request->input('email');
        $user->phone = $request->input('phone');
        $user->color = $request->input('selected_color');

        if (Auth::user()->is_admin) {
            $user->position = $request->input('position');
            $user->free_days = $request->input('free_days');
        }

        // Salvarea modificărilor
        $user->save();

        // Redirecționarea către pagina de profil a utilizatorului
        return redirect()->route('user-profile', ['id' => $user->id]);


    }

    public function changePassword(Request $request, $id) {
        // Obține utilizatorul specificat prin ID
        dd($id);
        $user = User::findOrFail($id);


//        // Validează datele de intrare
//        $request->validate([
//            'current_password' => 'required',
//            'new_password' => 'required|min:8|different:current_password|confirmed',
//        ]);

        // Verifică dacă parola curentă este corectă
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
