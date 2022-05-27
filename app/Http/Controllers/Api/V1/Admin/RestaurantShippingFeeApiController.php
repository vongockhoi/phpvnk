<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantShippingFeeRequest;
use App\Http\Requests\UpdateRestaurantShippingFeeRequest;
use App\Http\Resources\Admin\RestaurantShippingFeeResource;
use App\Models\RestaurantShippingFee;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantShippingFeeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('restaurant_shipping_fee_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurantShippingFeeResource(RestaurantShippingFee::with(['restaurant', 'district'])->get());
    }

    public function store(StoreRestaurantShippingFeeRequest $request)
    {
        $restaurantShippingFee = RestaurantShippingFee::create($request->all());

        return (new RestaurantShippingFeeResource($restaurantShippingFee))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RestaurantShippingFee $restaurantShippingFee)
    {
        abort_if(Gate::denies('restaurant_shipping_fee_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurantShippingFeeResource($restaurantShippingFee->load(['restaurant', 'district']));
    }

    public function update(UpdateRestaurantShippingFeeRequest $request, RestaurantShippingFee $restaurantShippingFee)
    {
        $restaurantShippingFee->update($request->all());

        return (new RestaurantShippingFeeResource($restaurantShippingFee))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RestaurantShippingFee $restaurantShippingFee)
    {
        abort_if(Gate::denies('restaurant_shipping_fee_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurantShippingFee->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
