<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Models\AdminView;
use App\Models\FreeDaysRequest;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;
use App\Mail\FreeDayStatusMail;


class AdminViewController extends Controller
{

    public function index()
    {
        return view('admin_view');
    }

    public function getData(){
        $adminCompanyId = auth()->user()->company_id;


        $data = FreeDaysRequest::with('user', 'category')
            ->whereHas('user', function ($query) use ($adminCompanyId) {
                $query->where('company_id', $adminCompanyId);
            })
            ->withTrashed()
            ->orderBy('created_at', 'desc')
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
                                    <button type="submit" class="btn btn-approve btn-sm" id="btnApprove" style="border: none; background-color: transparent;">
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
        $user = Auth::user();
        $request = FreeDaysRequest::findOrFail($id);
        $request->status = 'Approved';
        $request->save();

        $user = $request->user;
        $stats = $request->status;

        if ($user && $user->email) {
            Mail::to($user->email)->send(new FreeDayStatusMail($user, $stats, $request));
            // dd( $request->status);
        }

        return redirect('/admin-view')->with('success', 'Success');
    }

    public function deny($id)
    {
        $user = Auth::user();
        $request = FreeDaysRequest::findOrFail($id);
        $request->status = 'Denied';
        $request->save();

        $user = $request->user;

        $stats = $request->status;

         if ($user && $user->email) {
            Mail::to($user->email)->send(new FreeDayStatusMail($user, $stats, $request));
        }

        return redirect()->back()->with('success', 'Success');
    }

}
