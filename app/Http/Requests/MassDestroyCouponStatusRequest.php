<?php

namespace App\Http\Requests;

use App\Models\CouponStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCouponStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coupon_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coupon_statuses,id',
        ];
    }
}
