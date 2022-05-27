<?php

namespace App\Http\Requests\Api;

use App\Helpers\ResponseHelper;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Support\Facades\Log;

class LoginCustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone'    => 'required_without:email',
            'email'    => 'required_without:phone',
            'password' => 'required|min:6',
        ];
    }

    public function messages()
    {
        return [
            'phone.required_without' => 'Trường email là bắt buộc khi không có điện thoại.',
            'email.required_without' => 'Trường điện thoại là bắt buộc khi không có email.',
            'password.required'      => 'Mật khẩu là trường bắt buộc.',
            'password.min'           => 'Mật khẩu có ít nhất 6 ký tự.',
        ];
    }

    public function validated()
    {
        $validated = $this->validator->validated();
        if(empty($validated['email'])){
            $phone = convertPhone($validated['phone']);
            $validated['phone'] = $phone;
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
