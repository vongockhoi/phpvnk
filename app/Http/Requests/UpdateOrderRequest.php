<?php

namespace App\Http\Requests;

use App\Models\Order;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOrderRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        return [
            'code' => [
                'string',
                'required',
                'unique:orders,code,' . request()->route('order')->id,
            ],
            'customer_id' => [
                'required',
                'integer',
            ],
            'total_price' => [
                'required',
            ],
            'address_id' => [
                'nullable',
                'integer',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
