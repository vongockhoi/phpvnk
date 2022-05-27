<?php

namespace App\Http\Requests;

use App\Models\RestaurantStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyRestaurantStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('restaurant_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:restaurant_statuses,id',
        ];
    }
}
