<?php

namespace App\Http\Requests\Api\Auth\V2;

use App\Constants\Globals\Code;
use App\Helpers\ResponseHelper;
use App\Models\Customer;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Http\JsonResponse;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;
use Illuminate\Validation\Rule;

class SignUpCustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'first_name' => ['string', 'required'],
            'last_name' => ['string', 'nullable'],
            'phone' => ['required','regex:/^[+]?[0-9]{9,11}+$/'],
            'code'  => ['required']
        ];
    }

    public function messages()
    {
        return [
            'first_name.string' => 'Kiểu dữ liệu không phù hợp.',
            'first_name.required' => 'Vui lòng nhập chữ lót và tên.',

            'last_name.string' => 'Kiểu dữ liệu không phù hợp.',

            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',

            'code.required' => 'Vui lòng nhập mã opt của bạn.',
        ];
    }

    public function validated()
    {
        $validated = $this->validator->validated();
        $phone = convertPhone($validated['phone']);
        $customer = DB::table("customers")->where("phone", $phone)->whereNull("deleted_at")->first();
        if (!empty($customer)) {
            $response = ResponseHelper::failed("Số điện thoại đã tồn tại.", 422);
            throw new HttpResponseException($response);
        }
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
