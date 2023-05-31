<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Presentation extends Model
{
    use HasFactory;

    protected $fillable = [
        'path'
    ];

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($presentation) {
            Storage::delete(str_replace('storage/', 'public/', $presentation->path));
        });
    }
}
