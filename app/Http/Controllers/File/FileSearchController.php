<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use App\Http\Requests\File\FileSearchRequest;

class FileSearchController extends Controller
{
    /**
     * Search file by File Name
     *
     * @param [type] $filename
     * @return void
     */
    public function fileSearch(Request $request, $folder_id = null)
    {
        $fileNameSearch = $request->file_search;

        if ($fileNameSearch == null) {
            $files = File::where([
                ['parent_id', '=', $folder_id],
                ['user_id', '=', auth()->id()],
            ])->get();
        } else {
            $files = File::where([
                ['parent_id', '=', $folder_id],
                ['name', 'Like', '%' . $fileNameSearch . '%'],
                ['user_id', '=', auth()->id()],
            ])->get();
        }

        return view('layouts.home.main_page', compact('files'));
    }

    /**
     * Search file by File Name
     *
     * @param [type] $filename
     * @return void
     */
    public function fileTrashSearch(Request $request, $folder_id = null)
    {
        $fileNameSearch = $request->file_search;

        if ($fileNameSearch == null) {
            $files = File::onlyTrashed()->where([
                ['parent_id', '=', $folder_id],
                ['user_id', '=', auth()->id()],
            ])->get();
        } else {
            $files = File::onlyTrashed()->where([
                ['parent_id', '=', $folder_id],
                ['name', 'Like', '%' . $fileNameSearch . '%'],
                ['user_id', '=', auth()->id()],
            ])->get();
        }

        return view('layouts.home.trash', compact('files'));
    }
}
