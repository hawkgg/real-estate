<?php

namespace App\Http\Requests\Houses;

use Illuminate\Foundation\Http\FormRequest;

class UpdateRequest extends FormRequest
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
            'name' => 'required|max:255|unique:houses,name,'.$this->id,
            'price' => 'numeric|nullable|max:100000000',
            'currency' => 'numeric',
            'floors' => 'numeric|min:0|max:150|nullable',
            'bedrooms' => 'numeric|min:0|max:100|nullable',
            'square' => 'numeric|between:0,1000',
            'estate_type' => 'numeric',
            'village' => 'numeric',
            'photos.*' => 'mimes:jpeg,jpg,png',
        ];
    }
}
