<?php

namespace App\Http\Requests;

use App\Models\HashTag;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateHashTagRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('hash_tag_edit');
    }

    public function rules()
    {
        return [
            'name' => [
                'string',
                'required',
            ],
            'description' => [
                'string',
                'nullable',
            ],
        ];
    }
}
