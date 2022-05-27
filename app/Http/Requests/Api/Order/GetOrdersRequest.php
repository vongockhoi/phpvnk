<?php

namespace App\Http\Requests\Api\Order;

use App\Helpers\ResponseHelper;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class GetOrdersRequest extends FormRequest
{
    public function rules()
    {
        return [
            'limit' => ['nullable', 'integer'],
            'sort' => ['nullable', 'in:desc,asc'],
            'status_id' => ['nullable', 'array'],
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
