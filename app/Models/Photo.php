<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Photo extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($photo) {
            Storage::delete(str_replace('storage/', 'public/', $photo->path));
        });
    }
}
