@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.customer.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.customers.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.id') }}
                        </th>
                        <td>
                            {{ $customer->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.full_name') }}
                        </th>
                        <td>
                            {{ $customer->full_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.first_name') }}
                        </th>
                        <td>
                            {{ $customer->first_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.last_name') }}
                        </th>
                        <td>
                            {{ $customer->last_name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.avatar') }}
                        </th>
                        <td>
                            @if($customer->avatar)
                                <a href="{{ $customer->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $customer->avatar->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.birthday') }}
                        </th>
                        <td>
                            {{ $customer->birthday }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.phone') }}
                        </th>
                        <td>
                            {{ $customer->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.email') }}
                        </th>
                        <td>
                            {{ $customer->email }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.customer.fields.membership') }}
                        </th>
                        <td>
                            {{ $customer->membership->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.customers.index') }}">
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
        @can('cart_access')
            <li class="nav-item">
                <a class="nav-link" href="#customer_carts" role="tab" data-toggle="tab">
                    {{ trans('cruds.cart.title') }}
                </a>
            </li>
        @endcan
        <li class="nav-item">
            <a class="nav-link" href="#customer_orders" role="tab" data-toggle="tab">
                {{ trans('cruds.order.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_reservations" role="tab" data-toggle="tab">
                {{ trans('cruds.reservation.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#customer_addresses" role="tab" data-toggle="tab">
                {{ trans('cruds.address.title') }}
            </a>
        </li>
        @can('coupon_access')
            <li class="nav-item">
                <a class="nav-link" href="#customer_coupon_customers" role="tab" data-toggle="tab">
                    {{ trans('cruds.couponCustomer.title') }}
                </a>
            </li>
        @endcan
    </ul>
    <div class="tab-content">
        @can('cart_access')
            <div class="tab-pane" role="tabpanel" id="customer_carts">
                @includeIf('admin.customers.relationships.customerCarts', ['carts' => $customer->customerCarts])
            </div>
        @endcan
        <div class="tab-pane" role="tabpanel" id="customer_orders">
            @includeIf('admin.customers.relationships.customerOrders', ['orders' => $customer->customerOrders])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_reservations">
            @includeIf('admin.customers.relationships.customerReservations', ['reservations' => $customer->customerReservations])
        </div>
        <div class="tab-pane" role="tabpanel" id="customer_addresses">
            @includeIf('admin.customers.relationships.customerAddresses', ['addresses' => $customer->customerAddresses])
        </div>
        @can('coupon_access')
            <div class="tab-pane" role="tabpanel" id="customer_coupon_customers">
                @includeIf('admin.customers.relationships.customerCouponCustomers', ['couponCustomers' => $customer->customerCouponCustomers])
            </div>
        @endcan
    </div>
</div>

@endsection
