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
use const http\Client\Curl\AUTH_ANY;

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

        $authUser = Auth::user();
        $user = User::findOrFail($id);
        if (($authUser->is_admin && $authUser->company_id === $user->company_id ) || ($authUser->id === $user->id))
        {
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


    }else{
            redirect('/home');
        }
    }

    public function changePassword(Request $request, $id){

        $authUser = Auth::user();
        $user = User::findOrFail($id);

        if (($authUser->is_admin && $authUser->company_id === $user->company_id ) || ($authUser->id === $user->id)){
            $new_password = $request->input('newPassword');

            $user->password = Hash::make($new_password);

            if($user->save()) {
                return true;
            }  else {
                return false;
            }
        }

        else{
            return false;
        }

    }

}
