<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileMovingController extends Controller
{
    /**
     * Cut a file and store it in session for later pasting.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fileCut($id)
    {
        // Store the file ID in session for later pasting
        session(['cuted_file_id' => $id]);

        if (session('cuted_file_id')) {
            session()->forget('cuted_file_id');
        }

        return redirect()->back();
    }

    public function filePaste($folder_id = null)
    {
        $fileId = session('cuted_file_id');
        $fileCut = File::findOrFail($fileId);
        $fileCut->update([
            "parent_id" => $folder_id
        ]);
        return redirect()->back();
    }
}
