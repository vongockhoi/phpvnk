<?php

namespace App\Http\Requests;

use App\Models\CartDetail;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreCartDetailRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('cart_detail_create');
    }

    public function rules()
    {
        return [
            'cart_id' => [
                'required',
                'integer',
            ],
            'product_id' => [
                'required',
                'integer',
            ],
            'quantity' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
