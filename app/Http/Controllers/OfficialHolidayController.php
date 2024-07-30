<?php

namespace App\Http\Controllers;

use App\Models\OfficialHoliday;
use App\Http\Requests\StoreOfficial_holidaysRequest;
use App\Http\Requests\UpdateOfficial_holidaysRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

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

    public function getHolidays()
    {
            $holidays = OfficialHoliday::all()->map(function ($holiday) {
                return $holiday->only(['name', 'date']);
            });
            return response()->json($holidays);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function store(Request $request)
    {
            $request->validate([
                'name' => 'required|string|max:255',
                'date' => 'required|date',
            ]);

            $officialHoliday = new OfficialHoliday();
            $officialHoliday->name = $request->name;
            $officialHoliday->date = $request->date;
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

     public function getOfficialHolidays()
    {
        $holidays = OfficialHoliday::all()->pluck('date')->toArray();
        return response()->json($holidays);
    }
}
