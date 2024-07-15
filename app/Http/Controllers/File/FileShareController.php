<?php

namespace App\Http\Controllers\File;

use App\Models\File;
use App\Http\Controllers\Controller;
use App\Models\FileShared;

class FileShareController extends Controller
{
    public function shareFile($url)
    {
        $file = File::where([
            ['path', '=', $url]
        ])->first();

        FileShared::create([
            'file_id' => $file->id,
            'user_id' => auth()->id()
        ]);

        return redirect('/showAllFile');
    }
}
