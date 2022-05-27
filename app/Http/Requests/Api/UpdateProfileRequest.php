<?php

namespace App\Http\Requests\Api;

use App\Constants\Globals\Code;
use App\Helpers\ResponseHelper;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Client\Request;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Validation\Rule;

class UpdateProfileRequest extends FormRequest
{
    public function rules()
    {
        return [
            'full_name' => 'nullable',
            'first_name' => 'nullable',
            'last_name' => 'nullable',
            'birthday' => ['nullable', 'date_format:' . config('panel.date_format'),],
            'email' => ['email', 'nullable', Rule::unique('customers')->whereNull('deleted_at')],
            'avatar' => 'nullable|image',
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
