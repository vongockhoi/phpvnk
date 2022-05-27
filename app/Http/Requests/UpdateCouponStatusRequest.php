<?php

namespace App\Http\Requests;

use App\Models\CouponStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCouponStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_status_edit');
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
