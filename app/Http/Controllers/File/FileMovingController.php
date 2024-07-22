<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Support\Str;
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
            // Get the copied file ID from the session
            $copiedFileId = session('copied_file_id');

            if (!$copiedFileId) {
                return redirect()->back()->with('error', 'No file to paste.');
            }

            // Retrieve the copied file
            $file = File::find($copiedFileId);

            if (!$file) {
                return redirect()->back()->with('error', 'File not found.');
            }

            // Create a new copy of the file or folder
            $newFile = $file->replicate();
            $newFile->name = "copy_" . $file->name;
            $newFile->parent_id = $folder_id;
            $newFile->uploadName = Str::random(40) . '.' . $newFile->extension;
            $newFile->save();

            if ($file->type === 'folder') {
                // Recursively copy subfolders and files
                $this->copyChildren($file->id, $newFile->id);
            } else {
                Storage::copy($file->uploadName, $newFile->uploadname);
            }

            // Clear the copied file ID from session
            session()->forget('copied_file_id');

            return redirect()->back()->with('success', 'File pasted successfully.');
        }
    }

    /**
     * Copy sub file and folder
     *
     * @param mixed $oldParentId
     * @param mixed $newParentId
     * @return void
     */
    public function copyChildren($oldParentId, $newParentId)
    {
        $children = File::where('parent_id', $oldParentId)->get();

        foreach ($children as $child) {
            $newChild = $child->replicate();
            $newChild->name = "copy_" . $child->name;
            $newChild->parent_id = $newParentId;
            $newChild->uploadName = Str::random(40) . '.' . $newChild->extension;
            $newChild->save();

            if ($newChild->type === 'folder') {
                // Recursively copy subfolders and files
                $this->copyChildren($child->id, $newChild->id);
            } else {
                Storage::copy($child->uploadName, $newChild->uploadName);
            }
        }
    }
}
