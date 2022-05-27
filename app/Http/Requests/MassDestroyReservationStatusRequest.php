<?php

namespace App\Http\Requests;

use App\Models\ReservationStatus;
use Gate;
use Illuminate\Foundation\Http\FormRequest;
use Symfony\Component\HttpFoundation\Response;

class MassDestroyReservationStatusRequest extends FormRequest
{
    public function authorize()
    {
        abort_if(Gate::denies('reservation_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return true;
    }

    public function rules()
    {
        return [
            'ids'   => 'required|array',
            'ids.*' => 'exists:reservation_statuses,id',
        ];
    }
}
