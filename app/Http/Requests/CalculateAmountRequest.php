<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class CalculateAmountRequest extends FormRequest
{
    public function rules()
    {
        return [
            'orderId'  => [
                'required',
                'integer',
            ],
            'productArray' => [
                'required',
                'array',
            ],
        ];
    }
}
