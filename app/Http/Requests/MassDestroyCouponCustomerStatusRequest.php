<?php

namespace App\Http\Requests;

use App\Models\CouponCustomerStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCouponCustomerStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coupon_customer_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coupon_customer_statuses,id',
        ];
    }
}
