<?php

namespace App\Http\Requests;

use App\Models\CarBooking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyCarBookingRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('car_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:car_bookings,id',
        ];
    }
}
