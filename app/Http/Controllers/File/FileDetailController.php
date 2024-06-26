<?php

namespace App\Http\Controllers\File;

use App\Http\Controllers\Controller;
use App\Models\File;
use Illuminate\Http\Request;

class FileDetailController extends Controller
{
    public function showFileDetail($id){
        $fileDetail = File::findOrFail($id);

        return view('layouts.home.main_page', compact('fileDetail'));
    }
}
