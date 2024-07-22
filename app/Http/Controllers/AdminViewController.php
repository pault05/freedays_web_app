<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\AdminView;
use App\Models\FreeDaysRequest;

class AdminViewController extends Controller
{
    // admin view on hol req
    public function index()
    {
        $adminView = FreeDaysRequest::all();
        return view('admin_view', ['adminView' => $adminView]);
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
}
