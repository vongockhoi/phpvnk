<?php

namespace App\Http\Requests;

use App\Models\OperatingTime;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Response;

class UpdateOperatingTimeRequest extends FormRequest
{
    public function authorize()
    {
        return Gate::allows('operating_time_edit');
    }

    public function rules()
    {
        return [
            'restaurant_id' => [
                'required',
                'integer',
            ],
            'open_time' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'close_time' => [
                'required',
                'date_format:' . config('panel.time_format'),
            ],
            'day_off' => [
                'date_format:' . config('panel.date_format'),
                'nullable',
            ],
            'time_off' => [
                'date_format:' . config('panel.time_format'),
                'nullable',
            ],
        ];
    }
}
