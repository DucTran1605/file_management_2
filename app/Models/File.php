<?php

namespace App\Models;

use Spatie\Activitylog\LogOptions;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;
use Spatie\Activitylog\Models\Activity;
use Spatie\Activitylog\Traits\LogsActivity;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class File extends Model
{
    use HasFactory, SoftDeletes, LogsActivity;

    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
        'uploadName',
        'extension',
        'user_id',
        'parent_id',
        'shared_with',
    ];

    /**
     * Get user who share file
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
    /**
     * Get user that file will shared with
     */
    public function sharedWithUser()
    {
        return $this->belongsTo(User::class, 'shared_with');
    }

    /**
     * Get the parent folder of the file.
     */
    public function parent()
    {
        return $this->belongsTo(File::class, 'parent_id');
    }
    /**
     * Get the files and folders contained in this folder.
     */
    public function children()
    {
        return $this->hasMany(File::class, 'parent_id');
    }

    /**
     * Recursively delete all child files and folders.
     */
    public function deleteWithFileChildren()
    {
        // Recursively delete children
        foreach ($this->children()->withTrashed()->get() as $child) {
            $child->deleteWithFileChildren();
        }

        // Delete the current file/folder
        $this->delete();
    }

    /**
     * Recursively delete permently all child files and folders.
     */
    public function deletePermentlyWithFileChildren()
    {
        // Recursively delete children
        foreach ($this->children()->withTrashed()->get() as $child) {
            $child->deletePermentlyWithFileChildren();
        }

        // If the type is 'file', then delete the file from S3
        if ($this->type == 'file') {
            Storage::delete($this->uploadName);
            // Delete the current file/folder
            $this->forceDelete();
        } else {
            // Delete the current file/folder
            $this->forceDelete();
        }
        $fileActivity = Activity::where(
            [
                ['subject_id', '=', $this->id]
            ]
        )->get();
        foreach ($fileActivity as $activity) {
            $activity->delete();
        }
    }

    /**
     * Recursively restore all child files and folders.
     */
    public function restoreWithFileChildren()
    {
        // Recursively restore children
        foreach ($this->children()->withTrashed()->get() as $child) {
            $child->restoreWithFileChildren();
        }

        // restore the current file/folder
        $this->restore();
    }

    /**
     * Write log for File
     *
     * @return LogOptions
     */
    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()
            ->logOnly(['name']);
        // Chain fluent methods for configuration options
    }
}
