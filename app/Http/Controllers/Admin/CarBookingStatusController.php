<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarBookingStatusRequest;
use App\Http\Requests\StoreCarBookingStatusRequest;
use App\Http\Requests\UpdateCarBookingStatusRequest;
use App\Models\CarBookingStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarBookingStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('car_booking_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carBookingStatuses = CarBookingStatus::all();

        return view('admin.carBookingStatuses.index', compact('carBookingStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('car_booking_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carBookingStatuses.create');
    }

    public function store(StoreCarBookingStatusRequest $request)
    {
        $carBookingStatus = CarBookingStatus::create($request->all());

        return redirect()->route('admin.car-booking-statuses.index');
    }

    public function edit(CarBookingStatus $carBookingStatus)
    {
        abort_if(Gate::denies('car_booking_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carBookingStatuses.edit', compact('carBookingStatus'));
    }

    public function update(UpdateCarBookingStatusRequest $request, CarBookingStatus $carBookingStatus)
    {
        $carBookingStatus->update($request->all());

        return redirect()->route('admin.car-booking-statuses.index');
    }

    public function show(CarBookingStatus $carBookingStatus)
    {
        abort_if(Gate::denies('car_booking_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.carBookingStatuses.show', compact('carBookingStatus'));
    }

    public function destroy(CarBookingStatus $carBookingStatus)
    {
        abort_if(Gate::denies('car_booking_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carBookingStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarBookingStatusRequest $request)
    {
        CarBookingStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
