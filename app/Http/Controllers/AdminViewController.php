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
        $adminCompanyId = auth()->user()->company_id;

        $users = User::where('company_id', $adminCompanyId)
            ->whereHas('freeDays')
            ->get();
        $categories = Category::all();
        $statuses = FreeDaysRequest::distinct()->pluck('status');

        return view('admin_view', compact('users', 'categories', 'statuses'));
    }

    public function getData(Request $request){
        $adminCompanyId = auth()->user()->company_id;


        $query = FreeDaysRequest::with('user', 'category')
            ->whereHas('user', function ($query) use ($adminCompanyId) {
                $query->where('company_id', $adminCompanyId);
            });

//        if($request->filled('from_date') && $request->filled('end_date')){
//            $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('from_date'))->startOfDay();
//            $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->endOfDay();
//            $query->whereBetween('starting_date', [$startDate, $endDate])->orWhereBetween('ending_date', [$startDate, $endDate]);
//        }
//
//        $query->whereHas('user', function ($query) use ($adminCompanyId) { //daca faceam asta doar inainte de dates, nu se aplica (duh)
//            $query->where('company_id', $adminCompanyId);
//        });

//        $searchValue = $request->input('search.value');
//        if (!empty($searchValue)) {
//            $query->where(function ($q) use ($searchValue) {
//                $q->where('status', 'like', "%$searchValue%")
//                    ->orWhereHas('user', function ($q) use ($searchValue) {
//                        $q->where('first_name', 'like', "%$searchValue%")
//                            ->orWhere('last_name', 'like', "%$searchValue%");
//                    })
//                    ->orWhereHas('category', function ($q) use ($searchValue) {
//                        $q->where('name', 'like', "%$searchValue%");
//                    });
//            });
//        }

        $dataTables = DataTables::of($query);

        return $dataTables
            ->filter(function ($query) use ($request) {
                if ($request->filled('from_date') && $request->filled('end_date')) {
                    $startDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('from_date'))->startOfDay(); // rezolvat cautare si dates
                    $endDate = \Carbon\Carbon::createFromFormat('Y-m-d', $request->input('end_date'))->endOfDay();
                    $query->where(function($q) use ($startDate, $endDate) {
                        $q->whereBetween('starting_date', [$startDate, $endDate])
                            ->orWhereBetween('ending_date', [$startDate, $endDate]);
                    });
                }

                $searchValue = $request->input('search.value');
                if (!empty($searchValue)) {
                    $query->where(function ($q) use ($searchValue) {
                        $q->where('status', 'like', "%$searchValue%")
                            ->orWhere('description', 'like', "%$searchValue%")
                            ->orWhereHas('user', function ($q) use ($searchValue) {
                                $q->where('first_name', 'like', "%$searchValue%")
                                    ->orWhere('last_name', 'like', "%$searchValue%");
                            })
                            ->orWhereHas('category', function ($q) use ($searchValue) {
                                $q->where('name', 'like', "%$searchValue%");
                            });
                    });
                }
            })
            ->orderColumn('id', function ($query, $order) { // bun fix, am stat o ora si ca nu mai mergeau sortarile
                $query->orderBy('id', $order);
            })
            ->addColumn('user_name', function ($request) {
                return $request->user->first_name.' '.$request->user->last_name;
            })
            ->orderColumn('user_name', function($query, $order) {
                $query->join('users', 'free_days_requests.user_id', '=', 'users.id')
                    ->orderByRaw('CONCAT(users.first_name, " ", users.last_name) ' . $order);
            })
            ->addColumn('starting_date', function ($request) {
                return \Carbon\Carbon::parse($request->starting_date)->format('d-m-Y');
            })
            ->orderColumn('starting_date', function ($query, $order) {
                $query->orderBy('starting_date', $order);
            })
            ->addColumn('ending_date', function ($request) {
                return \Carbon\Carbon::parse($request->ending_date)->format('d-m-Y');
            })
            ->orderColumn('ending_date', function ($query, $order) {
                $query->orderBy('ending_date', $order);
            })
            ->addColumn('description', function ($request){
                return $request->description;
            })
            ->addColumn('category_name', function ($request) {
                return $request->category->name;
            })
            ->orderColumn('category_name', function($query, $order) {
                $query->join('categories', 'free_days_requests.category_id', '=', 'categories.id')
                    ->orderBy('categories.name', $order);
            })
            ->editColumn('status', function ($request) {
                return $request->status;
            })
            ->orderColumn('status', function($query, $order){
                $query->orderBy('status', $order);
            })
            ->filterColumn('user_name', function($query, $keyword) {
                $query->whereHas('user', function($q) use ($keyword) {
                    $q->where('id', $keyword);
                });
            })
            ->filterColumn('category_name', function($query, $keyword) {
                $query->whereHas('category', function($q) use ($keyword) {
                    $q->where('id', $keyword);
                });
            })
            ->filterColumn('status', function($query, $keyword) {
                $query->where('status', $keyword);
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
                                     <img src="https://img.icons8.com/?size=100&id=6697&format=png&color=228BE6" alt="" style="width: 30px; border: none; background-color: transparent" class="action-icons">
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

        return redirect()->route('admin-view.index')->with('success', 'Request updated successfully');
    }



   // Nu-l stergeti ca-l vreau amintire sa vad cat eram de ineficient
}
