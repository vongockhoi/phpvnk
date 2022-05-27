<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCouponStatusRequest;
use App\Http\Requests\StoreCouponStatusRequest;
use App\Http\Requests\UpdateCouponStatusRequest;
use App\Models\CouponStatus;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponStatusController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_status_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponStatuses = CouponStatus::all();

        return view('admin.couponStatuses.index', compact('couponStatuses'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_status_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponStatuses.create');
    }

    public function store(StoreCouponStatusRequest $request)
    {
        $couponStatus = CouponStatus::create($request->all());

        return redirect()->route('admin.coupon-statuses.index');
    }

    public function edit(CouponStatus $couponStatus)
    {
        abort_if(Gate::denies('coupon_status_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponStatuses.edit', compact('couponStatus'));
    }

    public function update(UpdateCouponStatusRequest $request, CouponStatus $couponStatus)
    {
        $couponStatus->update($request->all());

        return redirect()->route('admin.coupon-statuses.index');
    }

    public function show(CouponStatus $couponStatus)
    {
        abort_if(Gate::denies('coupon_status_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponStatuses.show', compact('couponStatus'));
    }

    public function destroy(CouponStatus $couponStatus)
    {
        abort_if(Gate::denies('coupon_status_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponStatus->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponStatusRequest $request)
    {
        CouponStatus::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
