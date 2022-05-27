<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRestaurantStatusRequest;
use App\Http\Requests\StoreRestaurantStatusRequest;
use App\Http\Requests\UpdateRestaurantStatusRequest;
use App\Models\RestaurantStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('restaurant_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurantStatuses = RestaurantStatus::all();

        return view('admin.restaurantStatuses.index', compact('restaurantStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('restaurant_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.restaurantStatuses.create');
    }

    public function store(StoreRestaurantStatusRequest $request)
    {
        $restaurantStatus = RestaurantStatus::create($request->all());

        return redirect()->route('admin.restaurant-statuses.index');
    }

    public function edit(RestaurantStatus $restaurantStatus)
    {
        abort_if(Gate::denies('restaurant_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.restaurantStatuses.edit', compact('restaurantStatus'));
    }

    public function update(UpdateRestaurantStatusRequest $request, RestaurantStatus $restaurantStatus)
    {
        $restaurantStatus->update($request->all());

        return redirect()->route('admin.restaurant-statuses.index');
    }

    public function show(RestaurantStatus $restaurantStatus)
    {
        abort_if(Gate::denies('restaurant_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.restaurantStatuses.show', compact('restaurantStatus'));
    }

    public function destroy(RestaurantStatus $restaurantStatus)
    {
        abort_if(Gate::denies('restaurant_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurantStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurantStatusRequest $request)
    {
        RestaurantStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
