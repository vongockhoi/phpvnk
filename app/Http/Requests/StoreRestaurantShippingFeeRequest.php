<?php

namespace App\Http\Requests;

use App\Models\RestaurantShippingFee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreRestaurantShippingFeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('restaurant_shipping_fee_create');
    }

    public function rules()
    {
        return [
            'restaurant_id' => [
                'required',
                'integer',
            ],
            'district_id' => [
                'required',
                'integer',
            ],
            'shipping_fee' => [
                'required',
            ],
        ];
    }
}
