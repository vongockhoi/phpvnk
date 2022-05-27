<?php

namespace App\Http\Requests;

use App\Models\RestaurantShippingFee;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateRestaurantShippingFeeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('restaurant_shipping_fee_edit');
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
