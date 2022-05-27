<?php

namespace App\Http\Requests;

use App\Models\RestaurantShippingFee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRestaurantShippingFeeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('restaurant_shipping_fee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:restaurant_shipping_fees,id',
        ];
    }
}
