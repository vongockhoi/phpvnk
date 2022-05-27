<?php

namespace App\Http\Requests;

use App\Models\CarBookingStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCarBookingStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('car_booking_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:car_booking_statuses,id',
        ];
    }
}
