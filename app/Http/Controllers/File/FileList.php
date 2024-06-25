<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileList extends Controller
{
    public function listAllFile(){
            $files = File::where('user_id', '=', auth()->id())->get();

            return view('layouts.home.main_page', compact('files'));
    }
}
