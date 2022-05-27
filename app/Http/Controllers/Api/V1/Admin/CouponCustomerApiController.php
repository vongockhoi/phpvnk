<?php

namespace App\Http\Controllers\Api\V1\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCouponCustomerRequest;
use App\Http\Requests\UpdateCouponCustomerRequest;
use App\Http\Resources\Admin\CouponCustomerResource;
use App\Models\CouponCustomer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponCustomerApiController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponCustomerResource(CouponCustomer::with(['coupon', 'customer', 'status'])->get());
    }

    public function store(StoreCouponCustomerRequest $request)
    {
        $couponCustomer = CouponCustomer::create($request->all());

        return (new CouponCustomerResource($couponCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_CREATED);
    }

    public function show(CouponCustomer $couponCustomer)
    {
        abort_if(Gate::denies('coupon_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return new CouponCustomerResource($couponCustomer->load(['coupon', 'customer', 'status']));
    }

    public function update(UpdateCouponCustomerRequest $request, CouponCustomer $couponCustomer)
    {
        $couponCustomer->update($request->all());

        return (new CouponCustomerResource($couponCustomer))
            ->response()
            ->setStatusCode(Response::HTTP_ACCEPTED);
    }

    public function destroy(CouponCustomer $couponCustomer)
    {
        abort_if(Gate::denies('coupon_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomer->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
