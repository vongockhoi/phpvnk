<?php

namespace App\Http\Requests\Api\Order;

use App\Constants\Order;
use App\Constants\ProductUnitConst;
use App\Helpers\ResponseHelper;
use App\Models\Product;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class AddToCartRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'product_id'                 => ['nullable', 'integer', Rule::exists("products", "id")],
            'quantity'                   => ['nullable', 'numeric', 'min:0.00', 'max:99999999.00'],
            'note'                       => ['nullable', 'string'],
            'free_one_product_parent_id' => ['nullable', 'string'],
            'address_id'                 => ['nullable', 'integer'],
            'coupon_customer_id'         => ['nullable', 'integer'],
            'restaurant_id'              => ['nullable', 'integer', Rule::exists("restaurants", "id")],
            'is_delivery'                => ['nullable', 'boolean'],
            'typeAction'                 => ['nullable', 'nullable', Rule::in(Order::TYPE_ACTION)],
        ];
        //        $isRemove = $this->input('typeAction');
        //        if ($isRemove != 2) {
        //            $rules['quantity'] = ['required', 'integer'];
        //        }

        $product_id = $this->input('product_id', null);
        if (!empty($product_id)) {
            $product = Product::with("product_unit")->find($product_id);
            if (!empty($product)) {
                $type = $product->product_unit ? $product->product_unit->type : null;
                if ($type == ProductUnitConst::TYPE['QUANTITY']) {
                    $rules['quantity'] = ['nullable', 'integer'];
                }
            }
        }

        return $rules;
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $response = ResponseHelper::failed($message, 422);
                throw new HttpResponseException($response);
            }
        }
    }

    public function messages()
    {
        return [
            //            "quantity.integer" => ""
        ];
    }
}
