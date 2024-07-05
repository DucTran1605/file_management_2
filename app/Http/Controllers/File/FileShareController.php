<?php

namespace App\Http\Controllers\File;

use ZipArchive;
use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileShareController extends Controller
{
    public function shareFile($url)
    {
        $fileShare = File::where('path', $url)->first();
        $fileShareId = $fileShare->id;
        $fileDownload = new FileDownloadController();

        // Find the file/folder
        $file = File::find($fileShareId);

        if (!$file) {
            return response()->json(['error' => 'File or folder not found'], 404);
        }

        // Set ZIP file name
        $zipFileName = $file->name . '.zip';
        $zip = new ZipArchive;
        $filePath = tempnam(sys_get_temp_dir(), $zipFileName);

        if ($zip->open($filePath, ZipArchive::CREATE) === TRUE) {
            // Add file/folder to ZIP
            $fileDownload->addFolderToZip($zip, $file, '');
            $zip->close();

            return response()->download($filePath, $zipFileName)->deleteFileAfterSend(true);
        } else {
            return response()->json(['error' => 'Failed to create zip file'], 500);
        }
    }
}
