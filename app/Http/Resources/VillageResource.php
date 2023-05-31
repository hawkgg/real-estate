<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class VillageResource extends JsonResource
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
            'address' => $this->address,
            'square' => $this->square,
            'phone' => $this->phone,
            'youtube_link' => $this->youtube_link,
            'photo' => $this->photo,
            'presentation' => $this->presentation,
        ];
    }
}
