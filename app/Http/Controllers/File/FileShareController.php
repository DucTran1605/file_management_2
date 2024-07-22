<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use App\Models\FileShared;
use Illuminate\Support\Str;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;
use App\Http\Controllers\File\FileMovingController;

class FileShareController extends Controller
{

    public function shareFile($url)
    {
        $fileMovingController = new FileMovingController();

        $file = File::where([
            ['path', '=', $url]
        ])->first();

        // Create a new copy of the file or folder
        $newFile = $file->replicate();
        $newFile->user_id = auth()->id();
        $newFile->parent_id = null; // Set parent_id to null
        $newFile->uploadName = Str::random(40) . '.' . $newFile->extension;
        $newFile->save();

        if ($file->type === 'folder') {
            // Recursively copy subfolders and files
            $fileMovingController->copyChildren($file->id, $newFile->id);
        } else {
            Storage::copy($file->uploadName, $newFile->uploadName);
        }

        return redirect('/showAllFile');
    }
}
