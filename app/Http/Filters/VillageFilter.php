<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class VillageFilter extends AbstractFilter
{
    public function getCallbacks(): array
    {
        return [
            'name' => [$this, 'name'],
        ];
    }

    public function name(Builder $builder, $value) {
        return $builder->where('name', 'like', "%$value%");
    }
}
