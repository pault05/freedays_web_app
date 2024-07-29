<?php

namespace App\Http\Controllers;

use App\Models\File;
use App\Http\Requests\StoreFilesRequest;
use App\Http\Requests\UpdateFilesRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FileController extends Controller
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
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {

    }

    /**
     * Display the specified resource.
     */
    public function show(File $files)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(File $files)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateFilesRequest $request, File $files)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(File $files)
    {
        //
    }
}
