<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Http\Resources\Admin\RestaurantResource;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class RestaurantApiController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('restaurant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurantResource(Restaurant::with(['province', 'district', 'status'])->get());
    }

    public function store(StoreRestaurantRequest $request)
    {
        $restaurant = Restaurant::create($request->all());

        if ($request->input('avatar', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
        }

        if ($request->input('featured_image', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
        }

        return (new RestaurantResource($restaurant))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new RestaurantResource($restaurant->load(['province', 'district', 'status']));
    }

    public function update(UpdateRestaurantRequest $request, Restaurant $restaurant)
    {
        $restaurant->update($request->all());

        if ($request->input('avatar', false)) {
            if (!$restaurant->avatar || $request->input('avatar') !== $restaurant->avatar->file_name) {
                if ($restaurant->avatar) {
                    $restaurant->avatar->delete();
                }
                $restaurant->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
            }
        } elseif ($restaurant->avatar) {
            $restaurant->avatar->delete();
        }

        if ($request->input('featured_image', false)) {
            if (!$restaurant->featured_image || $request->input('featured_image') !== $restaurant->featured_image->file_name) {
                if ($restaurant->featured_image) {
                    $restaurant->featured_image->delete();
                }
                $restaurant->addMedia(storage_path('tmp/uploads/' . basename($request->input('featured_image'))))->toMediaCollection('featured_image');
            }
        } elseif ($restaurant->featured_image) {
            $restaurant->featured_image->delete();
        }

        return (new RestaurantResource($restaurant))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
