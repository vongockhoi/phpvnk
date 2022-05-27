<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreRestaurantStatusRequest;
use App\Http\Requests\UpdateRestaurantStatusRequest;
use App\Http\Resources\Admin\RestaurantStatusResource;
use App\Models\RestaurantStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('restaurant_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurantStatusResource(RestaurantStatus::all());
    }

    public function store(StoreRestaurantStatusRequest $request)
    {
        $restaurantStatus = RestaurantStatus::create($request->all());

        return (new RestaurantStatusResource($restaurantStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(RestaurantStatus $restaurantStatus)
    {
        abort_if(Gate::denies('restaurant_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurantStatusResource($restaurantStatus);
    }

    public function update(UpdateRestaurantStatusRequest $request, RestaurantStatus $restaurantStatus)
    {
        $restaurantStatus->update($request->all());

        return (new RestaurantStatusResource($restaurantStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(RestaurantStatus $restaurantStatus)
    {
        abort_if(Gate::denies('restaurant_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurantStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
