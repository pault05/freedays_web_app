<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdminView;
use App\Models\FreeDaysRequest;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class AdminViewController extends Controller
{
    // admin view on hol req
    public function index()
    {
//        $sortField = $request->input('sort_field', 'starting_date');
//        $sortOrder = $request->input('sort_order', 'desc');
//
//        $filterByStatus = $request->input('filter_by_status', 'all');
//        $filterByUser = $request->input('filter_by_user', 'all');
//
//        $query = FreeDaysRequest::with('user', 'category');
//
//        if ($filterByStatus && $filterByStatus != 'all') {
//            $query->where('status', $filterByStatus);
//        }
//
//        if ($filterByUser && $filterByUser != 'all') {
//            $query->where('user_id', $filterByUser);
//        }
//
//        $query->orderBy($sortField, $sortOrder);
//
//        $adminView = $query->paginate(10)->appends([
//            'sort_field' => $sortField,
//            'sort_order' => $sortOrder,
//            'filter_by_status' => $filterByStatus,
//            'filter_by_user' => $filterByUser,
//        ]);
//
//        $users = FreeDaysRequest::with('user')
//            ->select('user_id')->distinct()->get()->pluck('user')->unique('id')->values();
//
//        return view('admin_view', ['adminView' => $adminView, 'sort_field' => $sortField, 'sort_order' => $sortOrder, 'users' => $users, 'filterByStatus' => $filterByStatus,
//            'filterByUser' =
        return view('admin_view');
    }

    public function getData(){
        $adminCompanyId = auth()->user()->company_id;

//        $data = FreeDaysRequest::with('user', 'category')->withTrashed()->get();
        $data = FreeDaysRequest::with('user', 'category')
            ->whereHas('user', function ($query) use ($adminCompanyId) {
                $query->where('company_id', $adminCompanyId);
            })
            ->withTrashed()
            ->get();
        return DataTables::of($data)
            ->addColumn('id', function ($request) {
                return $request->id;
            })
            ->addColumn('user_name', function ($request) {
                return $request->user->first_name.' '.$request->user->last_name;
            })
            ->addColumn('starting_date', function ($request) {
                return \Carbon\Carbon::parse($request->starting_date)->format('d-m-Y');
            })
            ->addColumn('ending_date', function ($request) {
                return \Carbon\Carbon::parse($request->ending_date)->format('d-m-Y');
            })
            ->addColumn('category_name', function ($request) {
                return $request->category->name;
            })
            ->editColumn('status', function ($request) {
                $statusColor = '';
                if ($request->status == 'Approved') {
                    $statusColor = '#28a745';
                } elseif ($request->status == 'Denied') {
                    $statusColor = '#bd2130';
                } else {
                    $statusColor = '#d39e00';
                }
                return '<span class="badge status-label" style="background-color: ' . $statusColor . ';">' . $request->status . '</span>';
            })
            ->addColumn('actions', function ($request) {
                $approveButton = '<form action="' . route('admin-view.approve', $request->id) . '" method="POST">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-approve btn-sm" id="btnApprove" style="border: none; background-color: transparent">
                                        <img src="https://img.icons8.com/?size=100&id=g7mUWNettfwZ&format=png&color=40C057" alt="" style="width: 35px" class="action-icons">
                                    </button>
                                  </form>';

                $denyButton = '<form action="' . route('admin-view.deny', $request->id) . '" method="POST">
                                    ' . csrf_field() . '
                                    <button type="submit" class="btn btn-deny btn-sm" id="btnDeny" style="border: none; background-color: transparent">
                                        <img src="https://img.icons8.com/?size=100&id=63688&format=png&color=000000" alt="" style="width: 30px; border: none; background-color: transparent" class="action-icons">
                                    </button>
                               </form>';

                return '<div style="display: flex; align-items: center;">' . $approveButton . $denyButton . '</div>';
            })
            ->rawColumns(['status', 'actions']) //pt a randa continut html
            ->make(true);
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

//    public function search(Request $request)
//    {
//        $data = $request->input('search');
//
//        if ($data) {
//            $records = FreeDaysRequest::whereHas('user', function ($query) use ($data) {
//                $query->where('first_name', 'like', '%' . $data . '%')
//                    ->orWhere('last_name', 'like', '%' . $data . '%');
//            })->with('user', 'category')->paginate(10);
//        } else {
//            $records = FreeDaysRequest::with('user', 'category')->paginate(10);
//        }
//
//        $users = FreeDaysRequest::with('user')
//            ->select('user_id')->distinct()->get()->pluck('user')->unique('id')->values();
//
//        return view('admin_view', ['adminView' => $records, 'users' => $users]);
//    }


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
