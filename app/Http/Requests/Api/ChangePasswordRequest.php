<?php

namespace App\Http\Requests\Api;

use App\Constants\Globals\Code;
use App\Helpers\ResponseHelper;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;

class ChangePasswordRequest extends FormRequest
{
    public function rules()
    {
        return [
            'curPassword'     => 'required',
            'password'        => 'required',
            'confirmPassword' => 'required|same:password|required_with:password'
        ];
    }

    public function messages()
    {
        return [
           //
        ];
    }

    public function validated()
    {
        return $this->validator->validated();
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
