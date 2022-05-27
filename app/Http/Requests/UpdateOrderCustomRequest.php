<?php

namespace App\Http\Requests;

use Gate;
use Illuminate\Foundation\Http\FormRequest;

class UpdateOrderCustomRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('order_edit');
    }

    public function rules()
    {
        $rules = [
            'order_id'       => [
                'string',
                'required',
                'exists:orders,id',
            ],
            'is_prepay'      => [
                'nullable',
                'integer',
            ],
            'is_delivery'    => [
                'nullable',
                'integer',
            ],
            'address_id'     => [
                'nullable',
                'integer',
            ],
            'status_id'      => [
                'required',
                'integer',
            ],
            'deposit_amount' => [
                'nullable',
                'numeric',
            ],
            'productArray'   => [
                'nullable',
                'array',
            ],
        ];

        return $rules;
    }
}
