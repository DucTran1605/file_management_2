<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class File extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'path',
        'size',
        'type',
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
     * Scope a query to only include files.
     */
    public function scopeFiles($query)
    {
        return $query->where('type', 'file');
    }

    /**
     * Scope a query to only include folders.
     */
    public function scopeFolders($query)
    {
        return $query->where('type', 'folder');
    }
}
