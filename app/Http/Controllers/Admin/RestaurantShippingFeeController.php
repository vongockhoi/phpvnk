<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyRestaurantShippingFeeRequest;
use App\Http\Requests\StoreRestaurantShippingFeeRequest;
use App\Http\Requests\UpdateRestaurantShippingFeeRequest;
use App\Models\District;
use App\Models\Restaurant;
use App\Models\RestaurantShippingFee;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantShippingFeeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('restaurant_shipping_fee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $restaurantShippingFees = RestaurantShippingFee::with(['restaurant', 'district']);

        if($user->isAdmin){
            $restaurantShippingFees->whereIn('restaurant_id', $user->restaurants->pluck('id')->toArray());
        }

        $restaurantShippingFees = $restaurantShippingFees->get();

        return view('admin.restaurantShippingFees.index', compact('restaurantShippingFees'));
    }

    public function create()
    {
        abort_if(Gate::denies('restaurant_shipping_fee_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if($user->isAdmin){
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $districts = District::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.restaurantShippingFees.create', compact('restaurants', 'districts'));
    }

    public function store(StoreRestaurantShippingFeeRequest $request)
    {
        $restaurantShippingFee = RestaurantShippingFee::create($request->all());

        return redirect()->route('admin.restaurant-shipping-fees.index');
    }

    public function edit(RestaurantShippingFee $restaurantShippingFee)
    {
        abort_if(Gate::denies('restaurant_shipping_fee_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $restaurants = Restaurant::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        if($user->isAdmin){
            $restaurants = Restaurant::whereIn('id', $user->restaurants->pluck('id')->toArray())->pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');
        }

        $districts = District::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurantShippingFee->load('restaurant', 'district');

        return view('admin.restaurantShippingFees.edit', compact('restaurants', 'districts', 'restaurantShippingFee'));
    }

    public function update(UpdateRestaurantShippingFeeRequest $request, RestaurantShippingFee $restaurantShippingFee)
    {
        $restaurantShippingFee->update($request->all());

        return redirect()->route('admin.restaurant-shipping-fees.index');
    }

    public function show(RestaurantShippingFee $restaurantShippingFee)
    {
        abort_if(Gate::denies('restaurant_shipping_fee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurantShippingFee->load('restaurant', 'district');

        return view('admin.restaurantShippingFees.show', compact('restaurantShippingFee'));
    }

    public function destroy(RestaurantShippingFee $restaurantShippingFee)
    {
        abort_if(Gate::denies('restaurant_shipping_fee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurantShippingFee->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurantShippingFeeRequest $request)
    {
        RestaurantShippingFee::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
