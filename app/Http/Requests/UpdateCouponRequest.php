<?php

namespace App\Http\Requests;

use App\Models\Coupon;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCouponRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('coupon_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:coupons,code,' . request()->route('coupon')->id,
            ],
            'name' => [
                'string',
                'required',
            ],
            'value' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'start_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'end_date' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'restaurants.*' => [
                'integer',
            ],
            'restaurants' => [
                'required',
                'array',
            ],
            'coupon_type_id' => [
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
