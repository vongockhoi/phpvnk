<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyRestaurantRequest;
use App\Http\Requests\StoreRestaurantRequest;
use App\Http\Requests\UpdateRestaurantRequest;
use App\Models\District;
use App\Models\Province;
use App\Models\Restaurant;
use App\Models\RestaurantStatus;
use App\Models\User;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class RestaurantController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('restaurant_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $user = User::find(auth()->id());

        $restaurants = Restaurant::with(['province', 'district', 'status', 'media']);

        if($user->isAdmin){
            $restaurants->whereIn('id', $user->restaurants->pluck('id')->toArray());
        }

        $restaurants = $restaurants->get();

        return view('admin.restaurants.index', compact('restaurants'));
    }

    public function create()
    {
        abort_if(Gate::denies('restaurant_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provinces = Province::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = RestaurantStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.restaurants.create', compact('provinces', 'districts', 'statuses'));
    }

    public function store(StoreRestaurantRequest $request)
    {
        $restaurant = Restaurant::create($request->all());

        if ($request->input('avatar', false)) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
        }

        foreach ($request->input('featured_image', []) as $file) {
            $restaurant->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('featured_image');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $restaurant->id]);
        }

        return redirect()->route('admin.restaurants.index');
    }

    public function edit(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $provinces = Province::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $districts = District::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = RestaurantStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurant->load('province', 'district', 'status');

        return view('admin.restaurants.edit', compact('provinces', 'districts', 'statuses', 'restaurant'));
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

        if (count($restaurant->featured_image) > 0) {
            foreach ($restaurant->featured_image as $media) {
                if (!in_array($media->file_name, $request->input('featured_image', []))) {
                    $media->delete();
                }
            }
        }
        $media = $restaurant->featured_image->pluck('file_name')->toArray();
        foreach ($request->input('featured_image', []) as $file) {
            if (count($media) === 0 || !in_array($file, $media)) {
                $restaurant->addMedia(storage_path('tmp/uploads/' . basename($file)))->toMediaCollection('featured_image');
            }
        }

        return redirect()->route('admin.restaurants.index');
    }

    public function show(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant->load('province', 'district', 'status', 'restaurantRestaurantShippingFees', 'restaurantOperatingTimes', 'restaurantProducts');

        return view('admin.restaurants.show', compact('restaurant'));
    }

    public function destroy(Restaurant $restaurant)
    {
        abort_if(Gate::denies('restaurant_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $restaurant->delete();

        return back();
    }

    public function massDestroy(MassDestroyRestaurantRequest $request)
    {
        Restaurant::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('restaurant_create') && Gate::denies('restaurant_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Restaurant();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
