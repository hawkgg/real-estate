<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class Village extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'address',
        'square',
        'phone',
        'youtube_link',
    ];

    /**
     * Get the photo of the village.
     */
    public function photo(): BelongsTo
    {
        return $this->belongsTo(Photo::class);
    }

    /**
     * Get the presentation of the village.
     */
    public function presentation(): BelongsTo
    {
        return $this->belongsTo(Presentation::class);
    }

    /**
     * Get the presentation of the village.
     */
    public function houses(): HasMany
    {
        return $this->hasMany(House::class);
    }

    /**
     * Scope a query for square.
     */
//    public function scopeSquare(Builder $query, $param): void
//    {
//        $query->where('square', $param);
//    }


    protected static function boot()
    {
        parent::boot();

        static::deleting(function($village) {
            Storage::deleteDirectory(str_replace('storage/', 'public/villages/', $village->id));
        });
    }
}
