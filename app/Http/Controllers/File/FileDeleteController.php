<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

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
        $deleteFile = File::findOrFail($id);
        $deleteFile->delete();

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
        $file->restore();
        return redirect()->back()->with('message', 'Restore file success');
    }
}
