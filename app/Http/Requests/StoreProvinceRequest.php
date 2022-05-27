<?php

namespace App\Http\Requests;

use App\Models\Province;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class StoreProvinceRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('province_create');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
        ];
    }
}
