<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileNameRequest;

class FileDetailController extends Controller
{
    public function showFileDetail($id)
    {
        $fileDetail = File::findOrFail($id);

        return view('layouts.partials.modal', compact('fileDetail'));
    }

    public function changeFileName(FileNameRequest $request, $id)
    {
        $fileDetail = File::findOrFail($id);

        $fileDetail->update($request->only('name'));

        return back()->with('message', 'Folder name update success');
    }
}
