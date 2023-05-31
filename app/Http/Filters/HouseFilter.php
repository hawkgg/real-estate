<?php

namespace App\Http\Filters;

use Illuminate\Database\Eloquent\Builder;

class HouseFilter extends AbstractFilter
{
    public function getCallbacks(): array
    {
        return [
            'name' => [$this, 'name'],
            'prices' => [$this, 'prices'],
            'currency' => [$this, 'currency'],
            'floors' => [$this, 'floors'],
            'bedrooms' => [$this, 'bedrooms'],
            'square' => [$this, 'square'],
            'estate_type' => [$this, 'estateType'],
            'village' => [$this, 'village'],
        ];
    }

    public function name(Builder $builder, $value) {
        return $builder->where('name', 'like', "%$value%");
    }

    public function prices(Builder $builder, $values) {
        return $builder->whereHas('prices', function($q) use ($values) {
            $q->whereBetween('val', $values);
        });
    }

    public function currency(Builder $builder, $value) {
        return $builder->where('default_currency_id', "$value");
    }

    public function floors(Builder $builder, $value) {
        return $builder->where('floors', $value);
    }

    public function bedrooms(Builder $builder, $value) {
        return $builder->where('bedrooms', $value);
    }

    public function square(Builder $builder, $value) {
        return $builder->where('square', $value);
    }

    public function estateType(Builder $builder, $value) {
        return $builder->where('estate_type_id', $value);
    }

    public function village(Builder $builder, $value) {
        return $builder->where('village_id', $value);
    }
}
