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
        $originalName = $uploadedFile->getClientOriginalName();

        // Check if the file name already exists and generate a unique name
        $filename = $this->generateUniqueFileName($originalName, $folder_id);

        // Store the file with the unique filename
        $uploadedFile->storeAs('', $filename); // Assuming you want to store in the root directory; adjust as necessary

        // Optionally, additional details can be saved to the database
        File::create([
            'name' => $filename,
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
}
