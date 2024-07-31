<?php
//
//namespace App\Http\Controllers;
//
//use App\Models\FreeDaysRequest;
//use App\Models\User;
//use Illuminate\Http\Request;
//use Illuminate\Support\Facades\Auth;
//use Illuminate\Support\Facades\Hash;
//use Illuminate\Testing\Fluent\Concerns\Has;
//use League\CommonMark\Node\Inline\AbstractInline;
//
//class UserProfileController extends Controller
//{
//    public function index($id)
//    {
//
//        $user = User::findOrFail($id);
//
//        return view('user_profile', ['user' => $user]);
//    }
//
//    public function save(Request $request,$id){
//        $request->validate([
//            'first_name' => 'required|string|max:255',
//            'last_name' => 'required|string|max:255',
//            'email' => 'required|string|email|max:255|unique:users,email,' . $id,
//            'phone' => 'nullable|string|max:20',
//            'selected_color' => 'nullable|string|max:7',
//            'position' => 'nullable|string|max:255', // Doar pentru admini
//            'free_days' => 'nullable|integer|min:0' // Doar pentru admini
//        ]);
//
//        $user = User::findOrFail($id);
//
//        $user->first_name = $request->input('first_name');
//        $user->last_name = $request->input('last_name');
//        $user->email = $request->input('email');
//        $user->phone = $request->input('phone');
//        $user->color = $request->input('selected_color');
//
//        if (Auth::user()->is_admin) {
//            $user->position = $request->input('position');
//            $user->free_days = $request->input('free_days');
//        }
//
//        $user->save();
//
//        return redirect()->route('user-profile', ['id' => $user->id]);
//
//
//    }
//
////    public function changePassword(Request $request) {
////        //dd($request);
////        $data = json_decode($request->getContent(), true);
////        $id = $data['user_id'];
////        $user = User::updateOrCreate([
////            'email' => $data['email']
////        ], [
////            'password' => Hash::make($data['new_password'])
////        ]);
////
////        $response = [];
////
//////        if (!Hash::check($data['current_password'], $user->password)) {
//////            //return redirect()->back()->withErrors(['current_password' => 'The current password is incorrect.']);
//////            $response['status'] = 'error';
//////            $response['message'] = 'The current password is incorrect.';
////
////
////////        } else {
//////            if ($data['new_password'] == $data['current_password']) {
//////                //return redirect()->back()->withErrors(['new_password' => 'The new password cannot be the same as current password.']);
//////                $response['status'] = 'error';
//////                $response['message'] = 'The new password cannot be the same as current password.';
//////            } else {
//////                $user->password = Hash::make($data['new_password']);
//////                $user->save();
////                $response['status'] = 'success';
////                $response['message'] = 'Password changed successfully!';
////                //return redirect()->back()->with('status', 'Password changed successfully!');
//////            }
//////        }
////
////        return json_encode($response);
////    }
////
//
//
//
//public function changePassword(Request $request)
//{
//    //Validare cerere
//    $validated = $request->validate([
//        'user_id' => 'required|integer|exists:users,id',
//        'new_password' => 'required|string|min:8|confirmed',
//    ]);
//
////    // Găsește utilizatorul
//    $user = User::findOrFail($validated['user_id']);
////
////    // Schimbă parola
//    $user->password = Hash::make($validated['new_password']);
//    $user->save();
////
////    // Răspuns JSON
//    return response()->json(['status' => 'success', 'message' => 'Password changed successfully!'], 200);
//}
//}
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

    public function changePassword(Request $request) {
//        dd($request->all());

        $id=$request->input('user_id');
//        dd($id);

        $user = User::findOrFail($id);
        $user->password = Hash::make(request()['new_password']);

        if($user->save()) {
            session()->flash('message', 'Password changed successfully.');
        }  else {
            session()->flash('message', 'Something went wrong.');
        }
//        dd($user->password);
        return redirect()->back();
    }

}
