<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponTypeRequest;
use App\Http\Requests\UpdateCouponTypeRequest;
use App\Http\Resources\Admin\CouponTypeResource;
use App\Models\CouponType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponTypeApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponTypeResource(CouponType::all());
    }

    public function store(StoreCouponTypeRequest $request)
    {
        $couponType = CouponType::create($request->all());

        return (new CouponTypeResource($couponType))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CouponType $couponType)
    {
        abort_if(Gate::denies('coupon_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponTypeResource($couponType);
    }

    public function update(UpdateCouponTypeRequest $request, CouponType $couponType)
    {
        $couponType->update($request->all());

        return (new CouponTypeResource($couponType))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CouponType $couponType)
    {
        abort_if(Gate::denies('coupon_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponType->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
