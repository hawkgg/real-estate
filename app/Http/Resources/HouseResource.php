<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class HouseResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'id' => $this->id,
            'name' => $this->name,
            'default_currency' => CurrencyResource::make($this->default_currency),
            'default_price' => PriceResource::make($this->default_price),
            'other_prices' => PriceResource::collection($this->other_prices),
            'floors' => $this->floors,
            'bedrooms' => $this->bedrooms,
            'square' => $this->square,
            'estate_type' => $this->estate_type,
            'village' => $this->village,
            'photos' => $this->photos,
        ];
    }
}
