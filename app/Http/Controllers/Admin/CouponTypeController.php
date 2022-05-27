<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCouponTypeRequest;
use App\Http\Requests\StoreCouponTypeRequest;
use App\Http\Requests\UpdateCouponTypeRequest;
use App\Models\CouponType;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponTypeController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_type_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponTypes = CouponType::all();

        return view('admin.couponTypes.index', compact('couponTypes'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_type_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponTypes.create');
    }

    public function store(StoreCouponTypeRequest $request)
    {
        $couponType = CouponType::create($request->all());

        return redirect()->route('admin.coupon-types.index');
    }

    public function edit(CouponType $couponType)
    {
        abort_if(Gate::denies('coupon_type_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponTypes.edit', compact('couponType'));
    }

    public function update(UpdateCouponTypeRequest $request, CouponType $couponType)
    {
        $couponType->update($request->all());

        return redirect()->route('admin.coupon-types.index');
    }

    public function show(CouponType $couponType)
    {
        abort_if(Gate::denies('coupon_type_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        return view('admin.couponTypes.show', compact('couponType'));
    }

    public function destroy(CouponType $couponType)
    {
        abort_if(Gate::denies('coupon_type_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponType->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponTypeRequest $request)
    {
        CouponType::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
