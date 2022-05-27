<?php

namespace App\Http\Requests\Api\Reservation;

use App\Helpers\ResponseHelper;
use Gate;
use Illuminate\Contracts\Validation\Validator;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Http\Exceptions\HttpResponseException;

class StoreReservationRequest extends FormRequest
{
    public function rules()
    {
        return [
            'phone' => [
                'string',
                'required',
            ],
            'date' => [
                'nullable',
                'date_format:' . config('panel.date_format'),
            ],
            'time' => [
                'nullable',
                'date_format:' . config('panel.time_format'),
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
