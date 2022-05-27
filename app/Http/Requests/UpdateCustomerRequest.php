<?php

namespace App\Http\Requests;

use App\Enums\Globals\Common as CommonEnum;
use App\Models\Customer;
use App\Models\MySQL\Category;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class UpdateCustomerRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('customer_edit');
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
                    ->whereNot('id', request()->route('customer')->id)
                    ->whereNull('deleted_at'),
            ],
            'email' => [
                'nullable',
                Rule::unique('customers', 'email')
                    ->whereNot('id', request()->route('customer')->id)
                    ->whereNull('deleted_at'),
//                'unique:customers,email,' . request()->route('customer')->id . ', deleted_at,null',
            ],
        ];
    }
}
