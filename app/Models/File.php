<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class File extends Model
{
    use HasFactory, SoftDeletes;

    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
        'uploadName',
        'extension',
        'user_id',
        'parent_id',
    ];

    /**
     * Get the user that owns the file.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
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
}
