<?php

namespace App\Http\Controllers;

use App\Models\UserFile;
use App\Http\Requests\StoreUser_filesRequest;
use App\Http\Requests\UpdateUser_filesRequest;
use Illuminate\Http\Request;

class UserFileController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Request $request): void
    {
        $userFileId = $request->input('file_id');
        $freeDaysReqID = $request->input('free_days_req_id');

        $UserFile = new UserFile();
        $UserFile->file_id = $userFileId;
        $UserFile->free_days_req_id = $freeDaysReqID;

        $UserFile->save();
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreUser_filesRequest $request)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(UserFile $user_files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(UserFile $user_files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateUser_filesRequest $request, UserFile $user_files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(UserFile $user_files)
    {
        //
    }
}
