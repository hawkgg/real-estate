<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Support\Facades\Storage;

class House extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'price_rub',
        'price_usd',
        'floors',
        'bedrooms',
        'square',
    ];

    /**
     * Get the photos of the house.
     */
    public function photos(): BelongsToMany
    {
        return $this->belongsToMany(Photo::class);
    }

    /**
     * Get the currency of the house.
     */
    public function default_currency(): BelongsTo
    {
        return $this->belongsTo(Currency::class, 'default_currency_id');
    }

    /**
     * Get the estate type of the house.
     */
    public function estate_type(): BelongsTo
    {
        return $this->belongsTo(EstateType::class, 'estate_type_id');
    }

    /**
     * Get the village of the house.
     */
    public function village(): BelongsTo
    {
        return $this->belongsTo(Village::class, 'village_id');
    }

    /**
     * Get the prices of the house.
     */
    public function prices(): hasMany
    {
        return $this->hasMany(Price::class);
    }

    /**
     * Get the default price of the house.
     */
    public function getDefaultPriceAttribute()
    {
        return $this->prices()->where('currency_id', $this->default_currency_id)->first()?->val;
    }

    protected static function boot()
    {
        parent::boot();

        static::deleting(function($house) {
            Storage::deleteDirectory(str_replace('storage/', 'public/houses/', $house->id));
        });
    }
}
