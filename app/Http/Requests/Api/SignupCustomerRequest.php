<?php

namespace App\Http\Requests\Api;

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

class SignupCustomerRequest extends FormRequest
{
    public function rules()
    {
        return [
            'full_name' => ['string', 'required',],
            'first_name' => ['string', 'required',],
            'last_name' => ['string', 'required',],
            'birthday' => ['nullable', 'date_format:' . config('panel.date_format'),],
            'phone' => ['required'],
            'email' => ['email', 'nullable', Rule::unique('customers')->whereNull('deleted_at')],
            'password' => ['required', 'min:6'],
        ];
    }

    public function messages()
    {
        return [
            'full_name.string' => 'Kiểu dữ liệu không phù hợp.',
            'full_name.required' => 'Vui lòng nhập họ tên đầy đủ.',

            'first_name.string' => 'Kiểu dữ liệu không phù hợp.',
            'first_name.required' => 'Vui lòng nhập chữ lót và tên.',

            'last_name.string' => 'Kiểu dữ liệu không phù hợp.',
            'last_name.required' => 'Vui lòng nhập họ của bạn.',

            'birthday.required' => 'Vui lòng nhập ngày sinh của bạn.',
            'birthday.date_format' => 'Sai định dạng ngày sinh Y-m-d.',

            'phone.regex' => 'Số điện thoại không hợp lệ.',
            'phone.required' => 'Vui lòng nhập số điện thoại của bạn.',
            'phone.unique' => 'Đã tồn tại số điện thoại.',

            'email.email' => 'Định dạng email không hợp lệ.',
            'email.required' => 'Vui lòng nhập email của bạn.',
            'email.unique' => 'Đã tồn tại email.',

            'password.required' => 'Mật khẩu là trường bắt buộc.',
            'password.min' => 'Mật khẩu có ít nhất 6 ký tự.',

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
