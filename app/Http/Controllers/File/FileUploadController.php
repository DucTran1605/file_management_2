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
        $originalName = $uploadedFile->getClientOriginalName();

        // Optionally, additional details can be saved to the database
        File::create([
            'name' => $this->generateUniqueFileName($originalName, $folder_id),
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
            'name' => $this->generateUniqueFoldeName($originalName, $folder_id),
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

    /**
     * Generate Unique File Name
     *
     * @param [type] $originalName
     * @param [type] $folder_id
     * @return void
     */
    private function generateUniqueFileName($originalName, $folder_id)
    {
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $extension = pathinfo($originalName, PATHINFO_EXTENSION);
        $counter = 1;
        $newName = $originalName;

        while (File::where('name', $newName)->where('parent_id', $folder_id)->exists()) {
            $newName = $name . '_' . $counter . '.' . $extension;
            $counter++;
        }

        return $newName;
    }

    /**
     * Generate Unique Folder Name
     *
     * @param [type] $originalName
     * @param [type] $folder_id
     * @return void
     */
    private function generateUniqueFoldeName($originalName, $folder_id)
    {
        $name = pathinfo($originalName, PATHINFO_FILENAME);
        $counter = 1;
        $newName = $originalName;

        while (File::where('name', $newName)->where('parent_id', $folder_id)->exists()) {
            $newName = $name . '_' . $counter;
            $counter++;
        }

        return $newName;
    }
}
