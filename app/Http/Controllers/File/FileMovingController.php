<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

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

        if (session('copied_file_id')) {
            session()->forget('copied_file_id');
        }

        return redirect()->back();
    }

    /**
     * Copy a file and store it in session for later pasting.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function fileCopy($id)
    {
        // Store the file ID in session for later pasting
        session(['copied_file_id' => $id]);

        if (session('cuted_file_id')) {
            session()->forget('cuted_file_id');
        }

        return redirect()->back();
    }

    /**
     * Paste file cut or copy
     *
     * @param [type] $folder_id
     * @return void
     */
    public function filePaste($folder_id = null)
    {
        if (session('cuted_file_id')) {
            $fileId = session('cuted_file_id');
            $fileCut = File::findOrFail($fileId);

            $fileCut->update([
                "parent_id" => $folder_id
            ]);

            session()->forget('cuted_file_id');

            return redirect()->back();
        } else if (session('copied_file_id')) {
            $parent_id = $folder_id;

            // Retrieve the copied file ID from the session
            $copiedFileId = session('copied_file_id');
            if (!$copiedFileId) {
                return redirect()->back()->with('errors', 'No Copied file');
            }

            // Retrieve copied file
            $file = File::findOrFail($copiedFileId);

            // Make a file copy record from the database
            $copiedFile = $file->replicate();
            $copiedFile->name = $file->name . '-copy';
            $copiedFile->parent_id = $parent_id;
            $copiedFile->uploadName = $this->generateCopyFileName($file->uploadName); // Generate a new unique upload name
            $copiedFile->save();

            //Upload file to s3 with uploadName
            Storage::copy('' . $file->uploadName, '' . $copiedFile->uploadName);

            // Paste all subfiles
            $this->pasteSubFiles($file, $copiedFile->id);

            session()->forget('copied_file_id');

            return redirect()->back()->with('message', 'Paste file successful');
        }
    }

    /**
     * generate name for copy file
     *
     * @param mixed $originalUploadName
     * @return string
     */
    private function generateCopyFileName($originalUploadName)
    {
        $pathInfo = pathinfo($originalUploadName);
        return $pathInfo['filename'] . '-copy.' . $pathInfo['extension'];
    }

    /**
     * Paste a sub file in folder
     *
     * @param mixed $originalFile
     * @param mixed $newParentId
     * @return void
     */
    private function pasteSubFiles($originalFile, $newParentId)
    {
        // Paste all subfiles
        foreach ($originalFile->children as $childFile) {
            // Make a subfile copy record from the database
            $copiedSubfile = $childFile->replicate();
            $copiedSubfile->parent_id = $newParentId;
            $copiedSubfile->uploadName = $this->generateCopyFileName($childFile->uploadName); // Generate a new unique upload name
            $copiedSubfile->save();

            // Recursively paste subfiles
            $this->pasteSubFiles($childFile, $copiedSubfile->id);
        }
    }
}
