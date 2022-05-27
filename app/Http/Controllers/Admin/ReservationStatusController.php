<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReservationStatusRequest;
use App\Http\Requests\StoreReservationStatusRequest;
use App\Http\Requests\UpdateReservationStatusRequest;
use App\Models\ReservationStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('reservation_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reservationStatuses = ReservationStatus::all();

        return view('admin.reservationStatuses.index', compact('reservationStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('reservation_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reservationStatuses.create');
    }

    public function store(StoreReservationStatusRequest $request)
    {
        $reservationStatus = ReservationStatus::create($request->all());

        return redirect()->route('admin.reservation-statuses.index');
    }

    public function edit(ReservationStatus $reservationStatus)
    {
        abort_if(Gate::denies('reservation_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reservationStatuses.edit', compact('reservationStatus'));
    }

    public function update(UpdateReservationStatusRequest $request, ReservationStatus $reservationStatus)
    {
        $reservationStatus->update($request->all());

        return redirect()->route('admin.reservation-statuses.index');
    }

    public function show(ReservationStatus $reservationStatus)
    {
        abort_if(Gate::denies('reservation_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.reservationStatuses.show', compact('reservationStatus'));
    }

    public function destroy(ReservationStatus $reservationStatus)
    {
        abort_if(Gate::denies('reservation_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reservationStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyReservationStatusRequest $request)
    {
        ReservationStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
