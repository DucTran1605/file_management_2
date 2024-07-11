<?php

namespace App\Http\Controllers\Activity;

use App\Models\File;
use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Spatie\Activitylog\Models\Activity;

class ActivityListController extends Controller
{
    /**
     * List all activity of file that user upload, count all file and folder user have
     *
     * @return void
     */
    public function listAllFile()
    {
        //Show log of file
        $activities = Activity::with(['subject' => function ($query) {
            $query->withTrashed();
        }])->where([
            ['causer_id', '=', auth()->id()],
        ])->orderBy('created_at', 'desc')->paginate(15);

        $memory = 0;

        $fileMemories = File::all();

        foreach ($fileMemories as $fileMemory) {
            $memory += $fileMemory->size / 1024;
        }

        // Count all entries with type 'file'
        $filesCount = File::where('type', '=', 'file')
            ->count();

        // Count all entries with type 'folder'
        $foldersCount = File::where('type', '=', 'folder')
            ->count();

        return view('layouts.home.activity', compact('activities', 'filesCount', 'foldersCount', 'memory'));
    }
}
