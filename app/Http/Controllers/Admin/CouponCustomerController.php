<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\MassDestroyCouponCustomerRequest;
use App\Http\Requests\StoreCouponCustomerRequest;
use App\Http\Requests\UpdateCouponCustomerRequest;
use App\Models\Coupon;
use App\Models\CouponCustomer;
use App\Models\CouponCustomerStatus;
use App\Models\Customer;
use Gate;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class CouponCustomerController extends Controller
{
    public function index()
    {
        abort_if(Gate::denies('coupon_customer_access'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomers = CouponCustomer::with(['coupon', 'customer', 'status'])->get();

        return view('admin.couponCustomers.index', compact('couponCustomers'));
    }

    public function create()
    {
        abort_if(Gate::denies('coupon_customer_create'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupons = Coupon::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customers = Customer::pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = CouponCustomerStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        return view('admin.couponCustomers.create', compact('coupons', 'customers', 'statuses'));
    }

    public function store(StoreCouponCustomerRequest $request)
    {
        $couponCustomer = CouponCustomer::create($request->all());

        return redirect()->route('admin.coupon-customers.index');
    }

    public function edit(CouponCustomer $couponCustomer)
    {
        abort_if(Gate::denies('coupon_customer_edit'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $coupons = Coupon::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $customers = Customer::pluck('phone', 'id')->prepend(trans('global.pleaseSelect'), '');

        $statuses = CouponCustomerStatus::pluck('name', 'id')->prepend(trans('global.pleaseSelect'), '');

        $couponCustomer->load('coupon', 'customer', 'status');

        return view('admin.couponCustomers.edit', compact('coupons', 'customers', 'statuses', 'couponCustomer'));
    }

    public function update(UpdateCouponCustomerRequest $request, CouponCustomer $couponCustomer)
    {
        $couponCustomer->update($request->all());

        return redirect()->route('admin.coupon-customers.index');
    }

    public function show(CouponCustomer $couponCustomer)
    {
        abort_if(Gate::denies('coupon_customer_show'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomer->load('coupon', 'customer', 'status', 'couponCustomerCarts', 'couponCustomerOrders');

        return view('admin.couponCustomers.show', compact('couponCustomer'));
    }

    public function destroy(CouponCustomer $couponCustomer)
    {
        abort_if(Gate::denies('coupon_customer_delete'), Response::HTTP_FORBIDDEN, '403 Forbidden');

        $couponCustomer->delete();

        return back();
    }

    public function massDestroy(MassDestroyCouponCustomerRequest $request)
    {
        CouponCustomer::whereIn('id', request('ids'))->delete();

        return response(null, Response::HTTP_NO_CONTENT);
    }
}
