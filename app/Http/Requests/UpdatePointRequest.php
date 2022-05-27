<?php

namespace App\Http\Requests;

use App\Models\Point;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdatePointRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('point_edit');
    }

    public function rules()
    {
        return [
            'customer_id' => [
                'required',
                'integer',
            ],
            'num_of_point' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
        ];
    }
}
