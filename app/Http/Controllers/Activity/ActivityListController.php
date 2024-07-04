<?php

namespace App\Http\Controllers\Activity;

use App\Http\Controllers\Controller;
use App\Models\User;
use Illuminate\Http\Request;
use Spatie\Activitylog\Models\Activity;

class ActivityListController extends Controller
{
    /**
     * List all activity of file that user upload
     *
     * @return void
     */
    public function listAllFile()
    {
        $activities = Activity::where([
            ['causer_id', '=', auth()->id()],
        ])->paginate(15);

        return view('layouts.home.activity', compact('activities'));
    }
}
