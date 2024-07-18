<?php

namespace App\Http\Controllers;

use App\Models\OfficialHoliday;
use App\Http\Requests\StoreOfficial_holidaysRequest;
use App\Http\Requests\UpdateOfficial_holidaysRequest;

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

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreOfficial_holidaysRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(Official_holiday $official_holidays)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Official_holiday $official_holidays)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateOfficial_holidaysRequest $request, Official_holiday $official_holidays)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Official_holiday $official_holidays)
    {
        //
    }
}
