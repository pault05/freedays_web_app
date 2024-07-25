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
        $request->validate([
            'file' => 'nullable|file|mimes:jpeg,jpg,png,pdf,doc,docx|max:5000'
        ]);

        if($request->hasFile('file'))
        {
            $file = $request->file('file');
            $fileName = time().'.'.$file->getClientOriginalExtension();
            $filePath = $file->storeAs('files', $fileName, 'public');

            $fileModel = new File();
            $fileModel->name = $file->getClientOriginalName();
            $fileModel->type = $file->getClientOriginalExtension();
            $fileModel->path = '/storage/' . $filePath;
            $fileModel->save();

            return back()->with('success', 'File has been uploaded successfully.');
        }
        return back()->withErrors('File upload failed.');
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
