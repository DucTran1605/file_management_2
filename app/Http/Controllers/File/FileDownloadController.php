<?php

namespace App\Http\Controllers\File;

use ZipArchive;
use App\Models\File;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Storage;

class FileDownloadController extends Controller
{
    public function downloadFolder($fileId)
    {
        // Find the file/folder
        $file = File::find($fileId);

        if (!$file) {
            return response()->json(['error' => 'File or folder not found'], 404);
        }

        // Set ZIP file name
        $zipFileName = $file->name . '.zip';
        $zip = new ZipArchive;
        $filePath = tempnam(sys_get_temp_dir(), $zipFileName);

        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
            // Add file/folder to ZIP
            $this->addFolderToZip($zip, $file, '');
            $zip->close();

            return response()->download($filePath, $zipFileName)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
    }

    /**
     * Add folders and files to a ZIP archive
     *
     * @param ZipArchive $zip
     * @param File $file
     * @param string $rootPath
     * @return void
     */
    private function addFolderToZip(ZipArchive $zip, File $file, $rootPath)
    {
        // Determine current path
        $currentPath = $rootPath ? $rootPath . '/' . $file->name : $file->name;

        if ($file->type === 'folder') {
            // Add empty directory for the folder
            $zip->addEmptyDir($currentPath);

            // Retrieve all child files/folders
            $childFiles = File::where('parent_id', $file->id)->get();

            foreach ($childFiles as $childFile) {
                // Recursively add child files and folders
                $this->addFolderToZip($zip, $childFile, $currentPath);
            }
        } elseif ($file->type === 'file') {
            // Add the actual file to the ZIP archive
            $fileContent = Storage::disk('s3')->get($file->uploadName);
            $zip->addFromString($currentPath, $fileContent);
        }
    }
}
