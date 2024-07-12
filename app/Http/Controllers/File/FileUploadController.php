<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Requests\File\FileUploadRequest;
use Spatie\Activitylog\Models\Activity;

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
        $fileName = $uploadedFile->getClientOriginalName();

        // Optionally, additional details can be saved to the database
        $file = File::create([
            'name' => $fileName,
            'path' => Str::random(10),
            'size' => $uploadedFile->getSize(),
            'type' => 'file',
            'uploadName' => $uploadName,
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => $fileExtension,
        ]);

        $file->update(['name' => $file->id . "_" . $fileName]);

        //Upload file to s3 with uploadName
        Storage::putFileAs('', $uploadedFile, $uploadName);

        // Get the ID of the newly created file
        $fileId = $file->id;

        return redirect()->back()->with('message', 'File upload success. File ID: ' . $fileId);
    }

    /**
     * Create folder
     *
     * @param Request $request
     * @param [type] $folder_id
     * @return void
     */
    public function createFolder(Request $request, $folder_id = null)
    {
        $originalName = $request->folder_name;

        File::create([
            'name' => $originalName,
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
