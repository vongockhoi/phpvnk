<?php

namespace App\Http\Requests\Api\Rating;

use App\Helpers\ResponseHelper;
use App\Models\Order;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class StoreRatingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => [
                'required',
                'integer',
                Rule::exists("orders", "id"),
                Rule::unique("ratings", "order_id")],
            'point_rating' => ['required', 'integer',],
        ];
    }

    public function validated()
    {
        $validated = $this->validator->validated();
        $order_id = $validated['order_id'];
        $order = Order::find($order_id);
        if ($order->status_id != 5) {
            $response = ResponseHelper::failed("Đơn hàng chưa được hoàn tất", 422);
            throw new HttpResponseException($response);
        }

        return $validated;
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
