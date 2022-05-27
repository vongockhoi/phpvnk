<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCarBookingRequest;
use App\Http\Requests\StoreCarBookingRequest;
use App\Http\Requests\UpdateCarBookingRequest;
use App\Models\CarBooking;
use App\Models\CarBookingStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CarBookingController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('car_booking_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carBookings = CarBooking::with(['status'])->get();

        return view('admin.carBookings.index', compact('carBookings'));
    }

    public function create()
    {
        abort_if(Gate::denies('car_booking_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = CarBookingStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.carBookings.create', compact('statuses'));
    }

    public function store(StoreCarBookingRequest $request)
    {
        $carBooking = CarBooking::create($request->all());

        return redirect()->route('admin.car-bookings.index');
    }

    public function edit(CarBooking $carBooking)
    {
        abort_if(Gate::denies('car_booking_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $statuses = CarBookingStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $carBooking->load('status');

        return view('admin.carBookings.edit', compact('statuses', 'carBooking'));
    }

    public function update(UpdateCarBookingRequest $request, CarBooking $carBooking)
    {
        $carBooking->update($request->all());

        return redirect()->route('admin.car-bookings.index');
    }

    public function show(CarBooking $carBooking)
    {
        abort_if(Gate::denies('car_booking_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carBooking->load('status');

        return view('admin.carBookings.show', compact('carBooking'));
    }

    public function destroy(CarBooking $carBooking)
    {
        abort_if(Gate::denies('car_booking_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $carBooking->delete();

        return back();
    }

    public function massDestroy(MassDestroyCarBookingRequest $request)
    {
        CarBooking::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
