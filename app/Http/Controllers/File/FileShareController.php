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
        $user = auth()->id(); // Assuming authentication is used
        $file = File::where([
            ['path', '=', $url]
        ])->first();

        // Update the file's shared path
        $file->shared_with = $user;
        $file->save();

        return view('layouts.home.main_page');
    }
}
