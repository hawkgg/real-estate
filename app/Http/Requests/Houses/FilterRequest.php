<?php

namespace App\Http\Requests\Houses;

use Illuminate\Foundation\Http\FormRequest;

class FilterRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     *
     * @return bool
     */
    public function authorize()
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'name' => 'string|max:255',
            'price_min' => 'numeric|nullable|between:0,100000000',
            'price_max' => 'numeric|nullable|between:0,100000000',
            'currency' => 'integer|nullable',
            'floors' => 'integer|nullable|between:0,150',
            'bedrooms' => 'integer|nullable|between:0,100',
            'square' => 'integer|nullable|between:0,1000',
            'estate_type' => 'integer|nullable',
            'village' => 'integer|nullable',
            'order_by' => 'string',
            'order_dir' => 'string',
            'page' => 'integer',
        ];
    }
}
