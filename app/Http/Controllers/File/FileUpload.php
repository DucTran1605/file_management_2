<?php

namespace App\Http\Controllers\File;

use App\Http\Requests\File\FileUploadRequest;
use App\Models\File;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileUpload extends Controller
{
    /**
     * Function to upload file into server
     *
     * @param Request $request
     * @return void
     */
    public function uploadFile(FileUploadRequest $request)
    {
        // Handle the validated file upload
        $uploadedFile = $request->file('file');
        $uploadedFile->storeAs('public/' . $uploadedFile->getClientOriginalName());

        // Optionally, additional details can be saved to the database
        $file = File::create([
            'name' => $uploadedFile->getClientOriginalName(),
            'path' => Str::random(40),
            'size' => $uploadedFile->getSize(),
            'type' => 'file',
            'user_id' => auth()->id(),
        ]);

        return redirect()->back()->with('message', 'File upload success');
    }
}
