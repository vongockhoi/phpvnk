<?php

namespace App\Http\Requests;

use App\Models\Customer;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_create');
    }

    public function rules()
    {
        return [
            'full_name' => [
                'string',
                'required',
            ],
            'first_name' => [
                'string',
                'required',
            ],
            'last_name' => [
                'string',
                'required',
            ],
            'avatar' => [
                'nullable',
            ],
            'birthday' => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'phone' => [
                'string',
                'required',
                Rule::unique('customers', 'phone')
                    ->whereNull('deleted_at'),
            ],
            'email' => [
                'nullable',
                'unique:customers',
            ],
            'password' => [
                'required',
            ],
        ];
    }
}
