<?php

namespace App\Http\Requests;

use App\Models\CouponCustomer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCouponCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_customer_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:coupon_customers,code,' . request()->route('coupon_customer')->id,
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
