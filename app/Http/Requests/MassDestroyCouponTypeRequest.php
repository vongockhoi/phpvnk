<?php

namespace App\Http\Requests;

use App\Models\CouponType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCouponTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('coupon_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:coupon_types,id',
        ];
    }
}
