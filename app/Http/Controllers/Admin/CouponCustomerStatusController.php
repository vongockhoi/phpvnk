<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCouponCustomerStatusRequest;
use App\Http\Requests\StoreCouponCustomerStatusRequest;
use App\Http\Requests\UpdateCouponCustomerStatusRequest;
use App\Models\CouponCustomerStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponCustomerStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_customer_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomerStatuses = CouponCustomerStatus::all();

        return view('admin.couponCustomerStatuses.index', compact('couponCustomerStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_customer_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponCustomerStatuses.create');
    }

    public function store(StoreCouponCustomerStatusRequest $request)
    {
        $couponCustomerStatus = CouponCustomerStatus::create($request->all());

        return redirect()->route('admin.coupon-customer-statuses.index');
    }

    public function edit(CouponCustomerStatus $couponCustomerStatus)
    {
        abort_if(Gate::denies('coupon_customer_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponCustomerStatuses.edit', compact('couponCustomerStatus'));
    }

    public function update(UpdateCouponCustomerStatusRequest $request, CouponCustomerStatus $couponCustomerStatus)
    {
        $couponCustomerStatus->update($request->all());

        return redirect()->route('admin.coupon-customer-statuses.index');
    }

    public function show(CouponCustomerStatus $couponCustomerStatus)
    {
        abort_if(Gate::denies('coupon_customer_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponCustomerStatuses.show', compact('couponCustomerStatus'));
    }

    public function destroy(CouponCustomerStatus $couponCustomerStatus)
    {
        abort_if(Gate::denies('coupon_customer_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomerStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponCustomerStatusRequest $request)
    {
        CouponCustomerStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
