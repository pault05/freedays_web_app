<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\FreeDaysRequest;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;

class FreeDaysRequestEditController extends Controller
{
    public function index(Request $request, $id) {
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
    
        $categories = Category::all();
    
        // Fetch the FreeDaysRequest by ID
        $freeDayRequest = FreeDaysRequest::findOrFail($id);
        
        $request_leave = [
            'user_id' => $user->id,
            'category_id' => $freeDayRequest->category_id,
            'status' => $freeDayRequest->status,
            'starting_date' => $freeDayRequest->starting_date,
            'ending_date' => $freeDayRequest->ending_date,
            'half_day' => $freeDayRequest->half_day,
            'description' => $freeDayRequest->description,
            'approved' => $approved
        ];
    
        $daysOffLeft = 21 - $approved;
    
        return view('free_day_edit', compact('request_leave', 'categories', 'daysOffLeft'));
    }
    
}
