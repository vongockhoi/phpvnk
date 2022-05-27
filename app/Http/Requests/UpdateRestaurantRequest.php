<?php

namespace App\Http\Requests;

use App\Models\Restaurant;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRestaurantRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('restaurant_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'province_id' => [
                'required',
                'integer',
            ],
            'district_id' => [
                'required',
                'integer',
            ],
            'address' => [
                'string',
                'required',
            ],
            'latitude' => [
                'numeric',
                'required',
            ],
            'longitude' => [
                'numeric',
                'required',
            ],
            'hotline' => [
                'nullable',
                'numeric',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
