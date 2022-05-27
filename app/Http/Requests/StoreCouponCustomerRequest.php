<?php

namespace App\Http\Requests;

use App\Models\CouponCustomer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCouponCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_customer_create');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:coupon_customers',
            ],
            'coupon_id' => [
                'required',
                'integer',
            ],
            'customer_id' => [
                'required',
                'integer',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
