<?php

namespace App\Http\Requests;

use App\Models\CarBooking;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarBookingRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_booking_edit');
    }

    public function rules()
    {
        return [
            'fullname' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'required',
                'integer',
                'min:-2147483648',
                'max:2147483647',
            ],
            'pick_up_point' => [
                'string',
                'nullable',
            ],
            'destination' => [
                'string',
                'nullable',
            ],
            'time' => [
                'date_format:' . config('panel.date_format') . ' ' . config('panel.time_format'),
                'nullable',
            ],
            'status_id' => [
                'required',
                'integer',
            ],
        ];
    }
}
