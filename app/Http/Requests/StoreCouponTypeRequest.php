<?php

namespace App\Http\Requests;

use App\Models\CouponType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCouponTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_type_create');
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
