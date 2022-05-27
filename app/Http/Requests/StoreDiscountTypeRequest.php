<?php

namespace App\Http\Requests;

use App\Models\DiscountType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreDiscountTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('discount_type_create');
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
