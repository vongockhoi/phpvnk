<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyReservationRequest;
use App\Http\Requests\StoreReservationRequest;
use App\Http\Requests\UpdateReservationRequest;
use App\Models\Customer;
use App\Models\Reservation;
use App\Models\ReservationStatus;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class ReservationController extends Controller
{
    public function index(Request $request)
    {
        abort_if(Gate::denies('reservation_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $reservations = Reservation::with(['customer', 'status', 'restaurant']);
        $from_date = $request->from_date ?? '';
        $to_date = $request->to_date ?? '';
        if ($user->isAdmin) {
            $reservations->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
        }
        if (!empty($request->from_date)) {
            $reservations = $reservations->whereDate("created_at", '>=', $request->from_date);
        }
        if (!empty($request->to_date)) {
            $reservations = $reservations->whereDate("created_at", '<=', $request->to_date);
        }
        $reservations = $reservations->get();

        return view('admin.reservations.index', compact('reservations','from_date','to_date'));
    }

    public function create()
    {
        abort_if(Gate::denies('reservation_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $customers = Customer::pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = ReservationStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if ($user->isAdmin) {
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }


        return view('admin.reservations.create', compact('customers', 'statuses', 'restaurants'));
    }

    public function store(StoreReservationRequest $request)
    {
        $reservation = Reservation::create($request->all());

        return redirect()->route('admin.reservations.index');
    }

    public function edit(Reservation $reservation)
    {
        abort_if(Gate::denies('reservation_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $customers = Customer::pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = ReservationStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if ($user->isAdmin) {
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $reservation->load('customer', 'status', 'restaurant');

        return view('admin.reservations.edit', compact('customers', 'statuses', 'reservation', 'restaurants'));
    }

    public function update(UpdateReservationRequest $request, Reservation $reservation)
    {
        $reservation->update($request->all());

        return redirect()->route('admin.reservations.index');
    }

    public function show(Reservation $reservation)
    {
        abort_if(Gate::denies('reservation_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reservation->load('customer', 'status');

        return view('admin.reservations.show', compact('reservation'));
    }

    public function destroy(Reservation $reservation)
    {
        abort_if(Gate::denies('reservation_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $reservation->delete();

        return back();
    }

    public function massDestroy(MassDestroyReservationRequest $request)
    {
        Reservation::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function countNewReservation()
    {
        $count = Reservation::where('status_id', 1);

        $user = User::find(auth()->id());

        if ($user->isAdmin) {
            $count->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
        }

        return $count->count();
    }
}
