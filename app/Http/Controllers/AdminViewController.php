<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdminView;
use App\Models\FreeDaysRequest;

class AdminViewController extends Controller
{
    // admin view on hol req
    public function index(Request $request)
    {
        $sortField = $request->input('sort_field', 'starting_date');
        $sortOrder = $request->input('sort_order', 'desc');

        $filterByStatus = $request->input('filter_by_status', 'all');
        $filterByUser = $request->input('filter_by_user', 'all');

        $query = FreeDaysRequest::with('user', 'category');

        if ($filterByStatus && $filterByStatus != 'all') {
            $query->where('status', $filterByStatus);
        }

        if ($filterByUser && $filterByUser != 'all') {
            $query->where('user_id', $filterByUser);
        }

        $query->orderBy($sortField, $sortOrder);

        $adminView = $query->paginate(10)->appends([
            'sort_field' => $sortField,
            'sort_order' => $sortOrder,
            'filter_by_status' => $filterByStatus,
            'filter_by_user' => $filterByUser,
        ]);

        $users = FreeDaysRequest::with('user')
            ->select('user_id')->distinct()->get()->pluck('user')->unique('id')->values();

        return view('admin_view', ['adminView' => $adminView, 'sort_field' => $sortField, 'sort_order' => $sortOrder, 'users' => $users, 'filterByStatus' => $filterByStatus,
            'filterByUser' => $filterByUser]);
    }

    public function approve($id)
    {
        $request = FreeDaysRequest::findOrFail($id);
        $request->status = 'Approved';
        $request->save();

        return redirect()->back()->with('success', 'Success');
    }

    public function deny($id)
    {
        $request = FreeDaysRequest::findOrFail($id);
        $request->status = 'Denied';
        $request->save();

        return redirect()->back()->with('success', 'Success');
    }

    public function search(Request $request)
    {
        $data = $request->input('search');

        if ($data) {
            $records = FreeDaysRequest::whereHas('user', function ($query) use ($data) {
                $query->where('first_name', 'like', '%' . $data . '%')
                    ->orWhere('last_name', 'like', '%' . $data . '%');
            })->with('user', 'category')->paginate(10);
        } else {
            $records = FreeDaysRequest::with('user', 'category')->paginate(10);
        }

        $users = FreeDaysRequest::with('user')
            ->select('user_id')->distinct()->get()->pluck('user')->unique('id')->values();

        return view('admin_view', ['adminView' => $records, 'users' => $users]);
    }


//    public function filter(Request $request){
//        $filterByStatus = $request->input('filter_by_status');
//        $filterByUser = $request->input('filter_by_user');
//
//        $query = FreeDaysRequest::with('user', 'category');
//
//
//        if ($filterByStatus) {
//            $query->where('status', $filterByStatus);
//        }
//
//        if ($filterByUser) {
//            $query->where('user_id', $filterByUser);
//        }
//
//        $adminView = $query->paginate(10);
//        $users = FreeDaysRequest::with('user')
//            ->select('user_id')->distinct()->get()->pluck('user')->unique('id')->values();
//
//        return view('admin_view', [
//            'adminView' => $adminView,
//            'filterByStatus' => $filterByStatus,
//            'filterByUser' => $filterByUser,
//            'users' => $users,
//        ]);
//    }

//    public function sort(Request $request){
//        $sortField = $request->input('sort_field', 'id');
//        $sortOrder = $request->input('sort_order', 'asc');
//
//        $adminView = FreeDaysRequest::join('users', 'free_days_requests.user_id', '=', 'users.id')
//            ->orderBy($sortField, $sortOrder)
//            ->select('free_days_requests.*')
//            ->with('user', 'category')
//            ->paginate(10);
//
//        return view('admin_view', ['adminView' => $adminView, 'sort_field' => $sortField, 'sort_order' => $sortOrder]);
//    }
//    public function sortByStatus(Request $request){
//
//        $adminView = FreeDaysRequest::with('user', 'category')->orderBy('status', 'desc')->paginate(10);
//
//        return view('admin_view', ['adminView' => $adminView]);
//    }

        // Nu-l stergeti ca-l vreau amintire sa vad cat eram de ineficient
}
