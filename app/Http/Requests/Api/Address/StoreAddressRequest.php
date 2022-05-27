<?php

namespace App\Http\Requests\Api\Address;

use App\Helpers\ResponseHelper;
use App\Models\Address;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreAddressRequest extends FormRequest
{
    public function rules()
    {
        return [
            'name' => [
                'string',
                'nullable',
            ],
            'note' => [
                'string',
                'nullable',
            ],
            'is_default' => [
                'boolean',
                'nullable',
            ],
            'province_id' => [
                'nullable',
                'integer',
            ],
            'district_id' => [
                'required',
                'integer',
            ],
            'address' => [
                'string',
                'required',
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
