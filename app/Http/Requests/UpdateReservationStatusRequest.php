<?php

namespace App\Http\Requests;

use App\Models\ReservationStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateReservationStatusRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('reservation_status_edit');
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
