<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use App\Models\SharedFile;
use App\Http\Controllers\Controller;
use Illuminate\Pagination\LengthAwarePaginator;

class FileListController extends Controller
{
    /**
     * List all file that user upload
     *
     * @return void
     */
    public function listAllFile()
    {
        $userId = auth()->id();

        // Retrieve the user's own files
        $ownFiles = File::where(function ($query) use ($userId) {
            $query->where('user_id', $userId)
                ->whereNull('parent_id');
        })->get();

        // Retrieve files shared with the user
        $sharedFiles = SharedFile::with('file')
            ->where('user_id', $userId)
            ->get()
            ->map(function ($sharedFile) {
                return $sharedFile->file;
            });

        // Merge the collections
        $allFiles = $ownFiles->merge($sharedFiles);

        // Get current page form url e.g. &page=6
        $currentPage = LengthAwarePaginator::resolveCurrentPage();

        // Define the number of items per page
        $perPage = 15;

        // Slice the collection to get the items to display in current page
        $currentItems = $allFiles->slice(($currentPage - 1) * $perPage, $perPage)->all();

        // Create LengthAwarePaginator instance
        $paginatedItems = new LengthAwarePaginator($currentItems, $allFiles->count(), $perPage);

        return view('layouts.home.main_page', ['files' => $paginatedItems]);
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
        ])->paginate(15);
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
            ['parent_id', '=', null],
            ['user_id', '=', auth()->id()]
        ])->paginate(15);
        return view('layouts.home.trash', compact('files'));
    }

    /**
     * Show specific folder in trash
     *
     * @param [type] $id
     * @return void
     */
    public function listSpecificTrashFolder($id)
    {
        $files = File::onlyTrashed()->where([
            ['user_id', '=', auth()->id()],
            ['parent_id', '=', $id]
        ])->paginate(15);
        return view('layouts.home.trash', compact('files'));
    }
}
