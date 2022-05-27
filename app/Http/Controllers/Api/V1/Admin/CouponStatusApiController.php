<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponStatusRequest;
use App\Http\Requests\UpdateCouponStatusRequest;
use App\Http\Resources\Admin\CouponStatusResource;
use App\Models\CouponStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponStatusResource(CouponStatus::all());
    }

    public function store(StoreCouponStatusRequest $request)
    {
        $couponStatus = CouponStatus::create($request->all());

        return (new CouponStatusResource($couponStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CouponStatus $couponStatus)
    {
        abort_if(Gate::denies('coupon_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponStatusResource($couponStatus);
    }

    public function update(UpdateCouponStatusRequest $request, CouponStatus $couponStatus)
    {
        $couponStatus->update($request->all());

        return (new CouponStatusResource($couponStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CouponStatus $couponStatus)
    {
        abort_if(Gate::denies('coupon_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
