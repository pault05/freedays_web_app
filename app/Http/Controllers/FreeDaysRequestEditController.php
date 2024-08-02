<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FreeDaysRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class FreeDaysRequestEditController extends Controller
{
    public function index($id)
    {
        $requestLeave = FreeDaysRequest::find($id);
        
        if (!$requestLeave) {
            return redirect()->back()->with('error', 'Request not found');
        }
    
        $categories = Category::all();
        
        $user = Auth::user();

        $approved = 0;
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

        $daysOffLeft = 21 - $approved;

        return view('free_day_edit', compact('requestLeave', 'categories', 'daysOffLeft'));
    }
}
