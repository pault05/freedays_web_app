<?php

namespace App\Http\Controllers;

use App\Models\OfficialHoliday;
use App\Http\Requests\StoreOfficial_holidaysRequest;
use App\Http\Requests\UpdateOfficial_holidaysRequest;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class OfficialHolidayController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $officialHolidays = OfficialHoliday::all();
        return view('official_holiday', ['officialHolidays' => $officialHolidays]);
    }

    public function getData()
    {
        $companyId = Auth::user()->company_id;

        $data = OfficialHoliday::where('company_id', $companyId)->get();

        return DataTables::of($data)
            ->addColumn('name', function($request){
                return $request->name;
            })
            ->addColumn('date', function($request){
                return \Carbon\Carbon::parse($request->date)->format('d-m-Y');
            })
            ->addColumn('actions', function($request){
                $deleteButton = '<form action="' . route('official-holiday.destroy', $request->id) . '" method="POST">
                                    ' . csrf_field() . '
                                    ' . method_field("DELETE") . '
                                    <button type="submit" style="border: none; background-color: rgba(0, 0, 0, 0)"><img class="w-25" title="Delete" src="https://img.icons8.com/?size=100&id=nerFBdXcYDve&format=png&color=FA5252" alt="" style="background-color: rgba(255, 255, 255, 0);">
                                </button>
                                  </form>';
                return '<div style="display: flex; align-items: center;">' . $deleteButton .'</div>';
            })
            ->rawColumns(['actions'])
            ->make(true);
    }

    public function getHolidays()
    {
        $companyId = Auth::user()->company_id;
        $holidays = OfficialHoliday::where('company_id', $companyId)->get()->map(function ($holiday) {
            return $holiday->only(['name', 'date']);
        });

//            $holidays = OfficialHoliday::all()->map(function ($holiday) {
//                return $holiday->only(['name', 'date']);
//            });
            return response()->json($holidays);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'date' => 'required|date'
        ]);

        $companyId = Auth::user()->company_id;

        $officialHoliday = new OfficialHoliday();
        $officialHoliday->name = $request->name;
        $officialHoliday->date = $request->date;
        $officialHoliday->company_id = $companyId;

        $officialHoliday->save();

        return redirect('/official-holiday');
    }

    public function deleteAll(){
        OfficialHoliday::truncate();
        return redirect('/official-holiday');
    }

    public function destroy($id){
            $ans = OfficialHoliday::find($id);
            $ans->delete();
        return redirect('/official-holiday');
    }

    public function show(OfficialHoliday $official_holidays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(OfficialHoliday $official_holidays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficial_holidaysRequest $request, OfficialHoliday $official_holidays)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
}
