<?php

namespace App\Http\Requests\Api\Auth\V2;

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
            'phone' => ['required','regex:/^[+]?[0-9]{9,11}+$/'],
            'type' => 'required'
        ];
    }

    public function messages()
    {
        return [
            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'code.required' => 'Vui lòng nhập mã opt của bạn.',
        ];
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
