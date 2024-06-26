<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileNameRequest;

class FileDetailController extends Controller
{
    public function showFileDetail($id)
    {
        $fileDetail = File::findOrFail($id);

        return view('layouts.home.main_page', compact('fileDetail'));
    }

    public function changeFileName(FileNameRequest $request, $id)
    {
        $change = DB::table('files')->where('id', $id)
            ->update(
                ['name' => $request->file_name]
            );
        dd($change);
    }
}
