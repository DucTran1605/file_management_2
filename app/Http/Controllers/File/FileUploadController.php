<?php

namespace App\Http\Controllers\File;

use App\Http\Requests\File\FileUploadRequest;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileUploadController extends Controller
{
    /**
     * Function to upload file into server
     *
     * @param Request $request
     * @return void
     */
    public function uploadFile(FileUploadRequest $request, $folder_id = null)
    {
        // Handle the validated file upload
        $uploadedFile = $request->file('file');
        $uploadedFile->storeAs($uploadedFile->getClientOriginalName());

        // Optionally, additional details can be saved to the database
        File::create([
            'name' => $request->file('file')->getClientOriginalName(),
            'path' => Str::random(40),
            'size' => $uploadedFile->getSize(),
            'type' => 'file',
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => $uploadedFile->getClientOriginalExtension(),
        ]);

        return redirect()->back()->with('message', 'File upload success');
    }

    public function createFolder(Request $request, $folder_id = null)
    {
        File::create([
            'name' => $request->folder_name,
            'path' => Str::random(40),
            'size' => "",
            'type' => 'folder',
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => "",
        ]);

        return redirect()->back()->with('message', 'Folder create success');
    }
}
