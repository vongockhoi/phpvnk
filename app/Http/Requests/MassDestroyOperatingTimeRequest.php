<?php

namespace App\Http\Requests;

use App\Models\OperatingTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyOperatingTimeRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('operating_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:operating_times,id',
        ];
    }
}
