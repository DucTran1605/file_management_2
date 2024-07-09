<?php

namespace App\Http\Controllers\File;

use App\Models\File;
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
        $newName = $request->only('name')['name'];

        if ($fileDetail->type === "file") {
            // Check if the new name has an extension
            if (!str_contains($newName, '.')) {
                $newName .= '.' . $fileDetail->extension;
            }
        }
        // Update the file name
        $fileDetail->update(['name' => $newName]);

        if ($fileDetail->type === 'folder') {
            return back()->with('message', 'Folder name update success');
        } else {
            return back()->with('message', 'File name update success');
        }
    }
}
