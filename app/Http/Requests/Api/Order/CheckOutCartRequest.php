<?php

namespace App\Http\Requests\Api\Order;

use App\Constants\Order;
use App\Helpers\ResponseHelper;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class CheckOutCartRequest extends FormRequest
{
    public function rules()
    {
        $rules = [
            'momo_token' => ['nullable'],
            'payment_method' => ['nullable', 'integer', Rule::in(Order::PAYMENT_METHOD)],
        ];

        $payment_method = $this->input('payment_method');
        if ($payment_method == Order::PAYMENT_METHOD['MOMO']) {
            $rules['momo_token'] = ['required'];
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
}
