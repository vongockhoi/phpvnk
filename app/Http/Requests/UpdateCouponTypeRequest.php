<?php

namespace App\Http\Requests;

use App\Models\CouponType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCouponTypeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_type_edit');
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
