<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponCustomerStatusRequest;
use App\Http\Requests\UpdateCouponCustomerStatusRequest;
use App\Http\Resources\Admin\CouponCustomerStatusResource;
use App\Models\CouponCustomerStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponCustomerStatusApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_customer_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponCustomerStatusResource(CouponCustomerStatus::all());
    }

    public function store(StoreCouponCustomerStatusRequest $request)
    {
        $couponCustomerStatus = CouponCustomerStatus::create($request->all());

        return (new CouponCustomerStatusResource($couponCustomerStatus))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CouponCustomerStatus $couponCustomerStatus)
    {
        abort_if(Gate::denies('coupon_customer_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponCustomerStatusResource($couponCustomerStatus);
    }

    public function update(UpdateCouponCustomerStatusRequest $request, CouponCustomerStatus $couponCustomerStatus)
    {
        $couponCustomerStatus->update($request->all());

        return (new CouponCustomerStatusResource($couponCustomerStatus))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CouponCustomerStatus $couponCustomerStatus)
    {
        abort_if(Gate::denies('coupon_customer_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomerStatus->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
