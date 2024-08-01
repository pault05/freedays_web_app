<?php

namespace App\Http\Controllers;

use App\Models\AdminViewUser;
use App\Http\Requests\StoreAdminViewUserRequest;
use App\Http\Requests\UpdateAdminViewUserRequest;
use App\Models\FreeDaysReqFile;
use App\Models\FreeDaysRequest;
use App\Models\User;
use App\Models\UserFile;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\DataTables;

class AdminViewUserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        return view('admin_view_user');
    }


    public function getData()
    {   $company_id = Auth::user()->company_id;
        $data = User::where('company_id', $company_id)->get();
        return DataTables::of($data)->addColumn('name', function ($request) {
            return $request->first_name . ' ' . $request->last_name;
        })
            ->addColumn('position', function ($request) {
                return $request->position;
            })
            ->addColumn('email', function ($request) {
                return $request->email;
            })
            ->addColumn('phone', function ($request) {
                return $request->phone;
            })
            ->addColumn('role', function ($request) {
                return $request->is_admin ? 'Admin' : 'User';
            })
            ->addColumn('free_days', function ($request) {
                return $request->free_days;
            })
            ->addColumn('hired_at', function ($request) {
                return Carbon::parse($request->hired_at)->format('d-m-Y'); // Sau alt format de dată dorit
            })
            ->addColumn('color', function ($request) {
                return $request->color;
            })
            ->addColumn('actions', function ($row) {
                $editButton = '<form action="' . route('user-profile', $row->id) . '" method="GET">
                                    <button class="btn-sm btnApprove" type="submit" style="width: 55px; border: none; background-color: transparent;">
                                        <img  style="width: 100%" src="https://img.icons8.com/?size=100&id=6697&format=png&color=228BE6" alt="Edit">
                                    </button>
                                </form>';

                $btnDelete = '<form action="' . route('admin-view-user.delete', $row->id) . '" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field("DELETE") . '
                                    <button class="btn-delete" type="submit" style="width: 55px; border: none; background-color: transparent;">
                                    <img  style="width: 100%" title="Delete" src="https://img.icons8.com/?size=100&id=nerFBdXcYDve&format=png&color=FA5252" alt="" style="background-color: rgba(255, 255, 255, 0);">
                                </button>
                                  </form>';

                $changePasswordButton = '<form action="' . route('user-profile.change-password', $row->id) . '" method="POST" class="change-password-form">
                            ' . csrf_field() . '
                            <button class="btn-change-password" type="submit" style="width: 55px; border: none; background-color: transparent;">
                                <img style="width: 100%" title="ChangePassword" src="https://img.icons8.com/?size=100&id=4fglYvlz5T4Q&format=png&color=000000" alt="" style="background-color: rgba(255, 255, 255, 0);">
                            </button>
                        </form>';


                return '<div style="display: flex; align-items: center;">' . $editButton . $btnDelete . $changePasswordButton . '</div>';
            })->rawColumns(['actions'])->make(true);
    }

    public function delete($id)
    {
        // Găsește utilizatorul
        $user = User::findOrFail($id);

//        // Găsește toate cererile de zile libere asociate utilizatorului
//        $free_day_requests = FreeDaysRequest::where('user_id', $user->id)->get();
//        foreach ($free_day_requests as $free_day_request) {
//            // Găsește și șterge toate fișierele asociate cererii de zile libere
//            FreeDaysReqFile::where('free_day_req_id', $free_day_request->id)->delete();
//            // Șterge cererea de zile libere
//            $free_day_request->delete();
//        }
//
//        // Găsește și șterge toate fișierele asociate utilizatorului
//        UserFile::where('user_id', $user->id)->delete();

        // Șterge utilizatorul
        $user->delete();

        return redirect()->back()->with('success', 'Utilizatorul și datele asociate au fost șterse cu succes.');
    }

}
