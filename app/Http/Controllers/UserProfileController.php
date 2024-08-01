<?php
namespace App\Http\Controllers;

use App\Models\FreeDaysRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Testing\Fluent\Concerns\Has;
use League\CommonMark\Node\Inline\AbstractInline;
use Psy\Readline\Hoa\Console;

class UserProfileController extends Controller
{
    public function index($id)
    {
        $authUser = Auth::user();

        if($authUser->id != $id && !$authUser->is_admin)
        {
            return view('/home');
        }

        $user = User::findOrFail($id);
        return view('user_profile', ['user' => $user]);
    }

    public function save(Request $request,$id){

//        dd($request->all());
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
            $user->is_admin = $request->role_text === 'Admin';
        }

        // Salvarea modificărilor
        $user->save();

        // Redirecționarea către pagina de profil a utilizatorului
        return redirect()->route('user-profile', ['id' => $user->id]);


    }

    public function changePassword(Request $request, $id){
//        return true;


//        dd($request->all());

//        $id=$request->input('user_id');
////        dd($id);
//        dd($request->all());
        $user = User::findOrFail($id);
        $new_password = $request->input('newPassword');

        $user->password = Hash::make($new_password);
//        $2y$12$ZQyS2IluIk3mSRIKwSiWmeLdC0MNRgFbvm5W6tOEFx91Lr9uFphtm
//$12$HJ0gBoPw0xDrepPXDQa3bun7aujngfiUFJHmKYH66COgq9pCnFQ6O
        if($user->save()) {
            return true;
        }  else {
            return false;
        }
////        dd($user->password);
//        return redirect()->back();
    }

}
