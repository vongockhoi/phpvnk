<?php

namespace App\Http\Requests;

use App\Models\RestaurantStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRestaurantStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('restaurant_status_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
