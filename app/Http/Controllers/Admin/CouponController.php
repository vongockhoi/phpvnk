<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Controllers\Traits\MediaUploadingTrait;
use App\Http\Requests\MassDestroyCouponRequest;
use App\Http\Requests\StoreCouponRequest;
use App\Http\Requests\UpdateCouponRequest;
use App\Jobs\CreateCouponForCustomerJob;
use App\Models\Coupon;
use App\Models\CouponStatus;
use App\Models\CouponType;
use App\Models\DiscountType;
use App\Models\Restaurant;
use Gate;
use Illuminate\Http\Request;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use Symfony\Component\HttpFoundation\Response;

class CouponController extends Controller
{
    use MediaUploadingTrait;

    public function index()
    {
        abort_if(Gate::denies('coupon_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupons = Coupon::with(['discount_type', 'restaurants', 'coupon_type', 'status', 'media'])->get();

        return view('admin.coupons.index', compact('coupons'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $discount_types = DiscountType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id');

        $coupon_types = CouponType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = CouponStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.coupons.create', compact('discount_types', 'restaurants', 'coupon_types', 'statuses'));
    }

    public function store(StoreCouponRequest $request)
    {
        $coupon = Coupon::create($request->all());
        $coupon->restaurants()->sync($request->input('restaurants', []));
        if ($request->input('avatar', false)) {
            $coupon->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
        }

        if ($media = $request->input('ck-media', false)) {
            Media::whereIn('id', $media)->update(['model_id' => $coupon->id]);
        }

        if(!empty($coupon)){
            CreateCouponForCustomerJob::dispatch($coupon);
        }

        return redirect()->route('admin.coupons.index');
    }

    public function edit(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $discount_types = DiscountType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $restaurants = Restaurant::pluck('name', 'id');

        $coupon_types = CouponType::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = CouponStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $coupon->load('discount_type', 'restaurants', 'coupon_type', 'status');

        return view('admin.coupons.edit', compact('discount_types', 'restaurants', 'coupon_types', 'statuses', 'coupon'));
    }

    public function update(UpdateCouponRequest $request, Coupon $coupon)
    {
        $coupon->update($request->all());
        $coupon->restaurants()->sync($request->input('restaurants', []));
        if ($request->input('avatar', false)) {
            if (!$coupon->avatar || $request->input('avatar') !== $coupon->avatar->file_name) {
                if ($coupon->avatar) {
                    $coupon->avatar->delete();
                }
                $coupon->addMedia(storage_path('tmp/uploads/' . basename($request->input('avatar'))))->toMediaCollection('avatar');
            }
        } elseif ($coupon->avatar) {
            $coupon->avatar->delete();
        }

        return redirect()->route('admin.coupons.index');
    }

    public function show(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupon->load('discount_type', 'restaurants', 'coupon_type', 'status', 'couponCouponCustomers');

        return view('admin.coupons.show', compact('coupon'));
    }

    public function destroy(Coupon $coupon)
    {
        abort_if(Gate::denies('coupon_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupon->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponRequest $request)
    {
        Coupon::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }

    public function storeCKEditorImages(Request $request)
    {
        abort_if(Gate::denies('coupon_create') && Gate::denies('coupon_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $model         = new Coupon();
        $model->id     = $request->input('crud_id', 0);
        $model->exists = true;
        $media         = $model->addMediaFromRequest('upload')->toMediaCollection('ck-media');

        return response()->json(['id' => $media->id, 'url' => $media->getUrl()], Response::HTTP_CREATED);
    }
}
