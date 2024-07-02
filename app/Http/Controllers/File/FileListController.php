<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class FileListController extends Controller
{
    /**
     * List all file that user upload
     *
     * @return void
     */
    public function listAllFile()
    {
        $files = File::where([
            ['user_id', '=', auth()->id()],
            ['parent_id', '=', null]
        ])->get();
        return view('layouts.home.main_page', compact('files'));
    }

    /**
     * Show specific folder in main page
     *
     * @param [type] $id
     * @return void
     */
    public function listSpecificFolder($id)
    {
        $folder_id = File::findOrFail($id)->id;
        $files = File::where([
            ['user_id', '=', auth()->id()],
            ['parent_id', '=', $id]
        ])->get();
        return view('layouts.home.main_page', compact('files', 'folder_id'));
    }

    /**
     * Show all file that put into trash
     *
     * @return void
     */
    public function showTrashedFile()
    {
        $files = File::onlyTrashed()->where([
            ['user_id', '=', auth()->id()]
        ])->get();
        return view('layouts.home.trash', compact('files'));
    }
}
