<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileDeleteController extends Controller
{
    /**
     * Remove file and put into trash
     *
     * @param [type] $id
     * @return void
     */
    public function deleteSoftFile($id)
    {
        // Find the file/folder by its ID
        $file = File::findOrFail($id);

        // Check if it is a folder
        if ($file->type == 'folder') {
            // Recursively delete the folder and all its contents
            $file->deleteWithFileChildren();
        } else {
            // Just delete the file
            $file->delete();
        }

        return redirect()->back()->with('message', 'Move file to the trash');
    }

    /**
     * Restore file from trash
     *
     * @param [type] $id
     * @return void
     */
    public function restoreFile($id)
    {
        $file = File::onlyTrashed()->findOrFail($id);
        // Check if it is a folder
        if ($file->type == 'folder') {
            // Recursively restore the folder and all its contents
            $file->restoreWithFileChildren();
        } else {
            // Just restore the file
            $file->restore();
        }
        return redirect()->back()->with('message', 'Restore file success');
    }

    /**
     * Delete a file Permanently
     *
     * @param [type] $id
     * @return void
     */
    public function forceDeleteFile($id)
    {
        $file = File::onlyTrashed()->findOrFail($id);
        Storage::delete($file->uploadName);
        $file->forceDelete();
        return redirect()->back()->with('message', 'Delete file success');
    }
}
