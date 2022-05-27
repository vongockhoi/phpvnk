<?php

namespace App\Http\Requests;

use App\Models\CouponCustomer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCouponCustomerRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coupon_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coupon_customers,id',
        ];
    }
}
