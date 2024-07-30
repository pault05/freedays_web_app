<?php

namespace App\Http\Controllers;

use App\Models\AdminViewUser;
use App\Http\Requests\StoreAdminViewUserRequest;
use App\Http\Requests\UpdateAdminViewUserRequest;
use App\Models\FreeDaysReqFile;
use App\Models\FreeDaysRequest;
use App\Models\User;
use App\Models\UserFile;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AdminViewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $company_id = Auth::user()->company_id;
        $sortBy = $request->get('sort_by', 'first_name'); // implicit sortare după 'first_name'
        $sortOrder = $request->get('sort_order', 'asc'); // implicit ordine ascendentă

        // Filtrare pe baza company_id și sortare
        $adminViewUser = User::where('company_id', $company_id)
            ->orderBy($sortBy, $sortOrder)
            ->paginate(10);

        return view('admin_view_user', compact('adminViewUser', 'sortBy', 'sortOrder'));
    }


    public function delete(Request $request)
    {
        $id=$request->input('user_id_delete');
        // Găsește utilizatorul
        $user = User::findOrFail($id);

        // Găsește toate cererile de zile libere asociate utilizatorului
        $free_day_requests = FreeDaysRequest::where('user_id', $user->id)->get();
        foreach ($free_day_requests as $free_day_request) {
            // Găsește și șterge toate fișierele asociate cererii de zile libere
            FreeDaysReqFile::where('free_day_req_id', $free_day_request->id)->delete();
            // Șterge cererea de zile libere
            $free_day_request->delete();
        }

        // Găsește și șterge toate fișierele asociate utilizatorului
        UserFile::where('user_id', $user->id)->delete();

        // Șterge utilizatorul
        $user->delete();

        return redirect()->back()->with('success', 'Utilizatorul și datele asociate au fost șterse cu succes.');
    }

}
