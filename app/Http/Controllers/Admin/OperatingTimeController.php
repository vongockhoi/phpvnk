<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyOperatingTimeRequest;
use App\Http\Requests\StoreOperatingTimeRequest;
use App\Http\Requests\UpdateOperatingTimeRequest;
use App\Models\OperatingTime;
use App\Models\Restaurant;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class OperatingTimeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('operating_time_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $operatingTimes = OperatingTime::with(['restaurant']);

        if($user->isAdmin){
            $operatingTimes->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
        }

        $operatingTimes = $operatingTimes->get();

        return view('admin.operatingTimes.index', compact('operatingTimes'));
    }

    public function create()
    {
        abort_if(Gate::denies('operating_time_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if($user->isAdmin){
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        return view('admin.operatingTimes.create', compact('restaurants'));
    }

    public function store(StoreOperatingTimeRequest $request)
    {
        $operatingTime = OperatingTime::create($request->all());

        return redirect()->route('admin.operating-times.index');
    }

    public function edit(OperatingTime $operatingTime)
    {
        abort_if(Gate::denies('operating_time_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if($user->isAdmin){
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $operatingTime->load('restaurant');

        return view('admin.operatingTimes.edit', compact('restaurants', 'operatingTime'));
    }

    public function update(UpdateOperatingTimeRequest $request, OperatingTime $operatingTime)
    {
        $operatingTime->update($request->all());

        return redirect()->route('admin.operating-times.index');
    }

    public function show(OperatingTime $operatingTime)
    {
        abort_if(Gate::denies('operating_time_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operatingTime->load('restaurant');

        return view('admin.operatingTimes.show', compact('operatingTime'));
    }

    public function destroy(OperatingTime $operatingTime)
    {
        abort_if(Gate::denies('operating_time_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $operatingTime->delete();

        return back();
    }

    public function massDestroy(MassDestroyOperatingTimeRequest $request)
    {
        OperatingTime::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
