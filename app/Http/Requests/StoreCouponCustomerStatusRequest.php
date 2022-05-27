<?php

namespace App\Http\Requests;

use App\Models\CouponCustomerStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCouponCustomerStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_customer_status_create');
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
