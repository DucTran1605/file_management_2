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
        $originalName = $uploadedFile->getClientOriginalName();

        //Check if user is in the root or in a folder
        if ($folder_id == null) {
            $filePath = null;
        } else {
            $filePath = File::findOrFail($folder_id)->name;
        }

        // Check if the file name already exists and generate a unique name
        $filename = $this->generateUniqueFileName($originalName, $filePath);

        // Optionally, additional details can be saved to the database
        File::create([
            'name' => $filename,
            'path' => Str::random(10),
            'size' => $uploadedFile->getSize(),
            'type' => 'file',
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => $uploadedFile->getClientOriginalExtension(),
        ]);

        Storage::disk('s3')->putFileAs($filePath, $uploadedFile, $filename);

        return redirect()->back()->with('message', 'File upload success');
    }

    public function createFolder(Request $request, $folder_id = null)
    {
        File::create([
            'name' => $request->folder_name,
            'path' => Str::random(10),
            'size' => "",
            'type' => 'folder',
            'parent_id' => $folder_id,
            'user_id' => auth()->id(),
            'extension' => "",
        ]);

        return redirect()->back()->with('message', 'Folder create success');
    }

    /**
     * Create a unique name for file
     *
     * @param [type] $originalName
     * @param [type] $folder_id
     * @return void
     */
    private function generateUniqueFileName($originalName, $filePath)
    {
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $counter = 1;
        $newName = $originalName;

        while (Storage::disk('s3')->exists("{$filePath}/{$newName}")) {
            $newName = $name . '_' . $counter . '.' . $extension;
            $counter++;
        }

        return $newName;
    }
}
