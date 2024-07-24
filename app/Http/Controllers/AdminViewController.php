<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminView;
use App\Models\FreeDaysRequest;
use Illuminate\Support\Facades\Auth;

class AdminViewController extends Controller
{
    // admin view on hol req
    public function index()
    {
        if(Auth::user()->is_admin) {
            $adminView = FreeDaysRequest::with('user')->paginate(10);
            return view('admin_view', ['adminView' => $adminView]);
        }
        return redirect('/home');
    }

    public function approve($id)
    {
        if(Auth::user()->is_admin) {
            $request = FreeDaysRequest::findOrFail($id);
            $request->status = 'Approved';
            $request->save();

            return redirect()->back()->with('success', 'Success');
        }
        return redirect('/home');
    }

    public function deny($id)
    {
        if(Auth::user()->is_admin) {
            $request = FreeDaysRequest::findOrFail($id);
            $request->status = 'Denied';
            $request->save();

            return redirect()->back()->with('success', 'Success');
        }
        return redirect('/home');
    }

    public function search(Request $request)
    {
        $data = $request->input('search');

        if ($data) {
            $records = FreeDaysRequest::whereHas('user', function($query) use ($data) {
                $query->where('first_name', 'like', '%' . $data . '%')
                    ->orWhere('last_name', 'like', '%' . $data . '%');
            })->paginate(10);
        } else {
            $records = FreeDaysRequest::with('user')->paginate(10);
        }

        return view('admin_view', ['adminView' => $records]);
    }

    public function sort(Request $request){
        $sortField = $request->input('sort_field', 'id');
        $sortOrder = $request->input('sort_order', 'asc');

        $adminView = FreeDaysRequest::join('users', 'free_days_requests.user_id', '=', 'users.id')
            ->orderBy($sortField, $sortOrder)
            ->select('free_days_requests.*')
            ->with('user')
            ->paginate(10);

        return view('admin_view', ['adminView' => $adminView, 'sort_field' => $sortField, 'sort_order' => $sortOrder]);
    }
    public function sortByStatus(Request $request){

        $adminView = FreeDaysRequest::orderBy('status', 'desc')->paginate(10);

        return view('admin_view', ['adminView' => $adminView]);
    }
}
