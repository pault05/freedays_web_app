<?php

namespace App\Http\Controllers;

use App\Models\AdminViewUser;
use App\Http\Requests\StoreAdminViewUserRequest;
use App\Http\Requests\UpdateAdminViewUserRequest;
use App\Models\User;
use Illuminate\Http\Request;

class AdminViewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $sortBy = $request->get('sort_by', 'first_name'); // implicit sortare după 'name'
        $sortOrder = $request->get('sort_order', 'asc'); // implicit ordine ascendentă
        $adminViewUser = User::orderBy($sortBy, $sortOrder)->paginate(10);
        return view('/admin_view_user', compact('adminViewUser', 'sortBy', 'sortOrder'));

    }


    public function delete($id){
        $user = User::findOrFail($id);
        $user->delete();
        return redirect()->back()->with('success', 'successfully.');
    }

}
