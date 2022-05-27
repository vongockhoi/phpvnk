@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.couponCustomer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coupon-customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.id') }}
                        </th>
                        <td>
                            {{ $couponCustomer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.code') }}
                        </th>
                        <td>
                            {{ $couponCustomer->code }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.coupon') }}
                        </th>
                        <td>
                            {{ $couponCustomer->coupon->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.customer') }}
                        </th>
                        <td>
                            {{ $couponCustomer->customer->phone ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.status') }}
                        </th>
                        <td>
                            {{ $couponCustomer->status->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coupon-customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>

<div class="card">
    <div class="card-header">
        {{ trans('global.relatedData') }}
    </div>
    <ul class="nav nav-tabs" role="tablist" id="relationship-tabs">
        @can('cart_management_access')
            <li class="nav-item">
                <a class="nav-link" href="#coupon_customer_carts" role="tab" data-toggle="tab">
                    {{ trans('cruds.cart.title') }}
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link" href="#coupon_customer_orders" role="tab" data-toggle="tab">
                {{ trans('cruds.order.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="coupon_customer_carts">
            @includeIf('admin.couponCustomers.relationships.couponCustomerCarts', ['carts' => $couponCustomer->couponCustomerCarts])
        </div>
        <div class="tab-pane" role="tabpanel" id="coupon_customer_orders">
            @includeIf('admin.couponCustomers.relationships.couponCustomerOrders', ['orders' => $couponCustomer->couponCustomerOrders])
        </div>
    </div>
</div>

@endsection