<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\File\FileUploadRequest;

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
        $fileExtension = $uploadedFile->getClientOriginalExtension();
        $uploadName = Str::random(40) . '.' . $fileExtension;

        // Optionally, additional details can be saved to the database
        File::create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => Str::random(10),
            'size' => $uploadedFile->getSize(),
            'type' => 'file',
            'uploadName' => $uploadName,
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => $fileExtension,
        ]);

        Storage::disk('s3')->putFileAs('', $uploadedFile, $uploadName);

        return redirect()->back()->with('message', 'File upload success');
    }

    public function createFolder(Request $request, $folder_id = null)
    {
        File::create([
            'name' => $request->folder_name,
            'path' => Str::random(10),
            'size' => "",
            'type' => 'folder',
            'uploadName' => "",
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => "",
        ]);

        return redirect()->back()->with('message', 'Folder create success');
    }
}
