<?php

namespace App\Http\Requests\Api;

use App\Helpers\ResponseHelper;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class VerifyOTPRequest extends FormRequest
{
    public function rules()
    {
        return [
            'code' => 'required',
            'phone' => 'required'
        ];
    }

    public function messages()
    {
        return [];
    }

    public function validated()
    {
        $validated = $this->validator->validated();
        $phone = convertPhone($validated['phone']);
        $validated['phone'] = $phone;
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
