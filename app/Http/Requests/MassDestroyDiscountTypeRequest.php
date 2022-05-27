<?php

namespace App\Http\Requests;

use App\Models\DiscountType;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyDiscountTypeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('discount_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:discount_types,id',
        ];
    }
}
