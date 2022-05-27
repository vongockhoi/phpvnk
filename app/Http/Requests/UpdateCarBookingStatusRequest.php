<?php

namespace App\Http\Requests;

use App\Models\CarBookingStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateCarBookingStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('car_booking_status_edit');
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
