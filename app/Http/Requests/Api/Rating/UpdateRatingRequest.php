<?php

namespace App\Http\Requests\Api\Rating;

use App\Helpers\ResponseHelper;
use App\Models\Order;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Validation\Rule;

class UpdateRatingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'order_id' => [
                'required',
                'integer',
                Rule::exists("ratings", "order_id"),],
            'point_rating' => ['required', 'integer',],
        ];
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
