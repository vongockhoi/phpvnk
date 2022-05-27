<?php

namespace App\Http\Requests\Api\Restaurant;


use App\Helpers\ResponseHelper;
use App\Models\Address;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;

class GetRestaurantDetailRequest extends FormRequest
{

    public function rules()
    {
        return [
            'id' => [
                'required',
                'integer',
            ],
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
