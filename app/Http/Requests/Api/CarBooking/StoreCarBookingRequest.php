<?php

namespace App\Http\Requests\Api\CarBooking;

use App\Helpers\ResponseHelper;
use App\Models\Address;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;
use Illuminate\Http\Response;
use Illuminate\Validation\Rule;

class StoreCarBookingRequest extends FormRequest
{
    public function rules()
    {
        return [
            'fullname' => [
                'string',
                'nullable',
            ],
            'phone' => [
                'required',
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
        ];
    }

    protected function failedValidation(Validator $validator)
    {
        if ($validator->fails()) {
            $errors = $validator->errors();
            foreach ($errors->all() as $message) {
                $response = ResponseHelper::failed($message, 422);
                throw new HttpResponseException($response);
            }
        }
    }
}
