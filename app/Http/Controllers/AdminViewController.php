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
use App\Models\Category;

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
                
                $extraButton = '';
                if($request->status == 'Pending') {
                    $extraButton = '<a href="' . route('free-day-edit', ['id' => $request->id]) . '" class="btn btn-edit btn-sm" id="btnEdit" style="border: none; background-color: transparent">
                                     <img src="https://img.icons8.com/?size=100&id=4fglYvlz5T4Q&format=png&color=000000" alt="" style="width: 30px; border: none; background-color: transparent" class="action-icons">
                                 </a>';
                }
                          return '<div style="display: flex; align-items: center;">' . $approveButton . $denyButton . $extraButton . '</div>';

            })
            ->rawColumns(['status', 'actions'])
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

    public function editRequest($id)
    {
        $freeDayRequest = FreeDaysRequest::find($id);
        
        if (!$freeDayRequest) {
            return redirect()->back()->with('error', 'Request not found');
        }
    
        $approved = 0; 
        $user = Auth::user(); 
    
        // Logica pentru a calcula zilele aprobate
        if (isset($user->freeDays) && count($user->freeDays)) {
            foreach ($user->freeDays as $day) {
                if ($day->status == 'Approved' && $day->category->is_subtractable == 1) {
                    if ($day->half_day) {
                        $approved += 0.5;
                    } else {
                        $approved += $day->days;
                    }
                }
            }
        }
    
        $categories = Category::all();
        $daysOffLeft = 21 - $approved; 
    
        return view('free_day_request', compact('freeDayRequest', 'daysOffLeft', 'categories'));
    }
    
    public function updateRequest(Request $request, $id)
    {
        $freeDayRequest = FreeDaysRequest::find($id);
        
        if (!$freeDayRequest) {
            return redirect()->back()->with('error', 'Request not found');
        }
    
        $validatedData = $request->validate([
            'category_id' => 'sometimes|required|exists:categories,id',
            'starting_date' => 'sometimes|required|date|',
            'ending_date' => 'sometimes|required|date|after_or_equal:starting_date',
            'description' => 'sometimes|nullable|string|max:255',
        ]);
    
        $freeDayRequest->update(array_filter($validatedData));
    
        return redirect()->route('admin_view')->with('success', 'Request updated successfully');
    }
    
    
    
   // Nu-l stergeti ca-l vreau amintire sa vad cat eram de ineficient
}
