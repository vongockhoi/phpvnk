@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cart.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.carts.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cart.fields.id') }}
                        </th>
                        <td>
                            {{ $cart->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cart.fields.customer') }}
                        </th>
                        <td>
                            {{ $cart->customer->phone ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cart.fields.total_price') }}
                        </th>
                        <td>
                            {{ $cart->total_price }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cart.fields.address') }}
                        </th>
                        <td>
                            {{ $cart->address->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cart.fields.coupon_customer') }}
                        </th>
                        <td>
                            {{ $cart->coupon_customer->code ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.carts.index') }}">
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
        <li class="nav-item">
            <a class="nav-link" href="#cart_cart_details" role="tab" data-toggle="tab">
                {{ trans('cruds.cartDetail.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="cart_cart_details">
            @includeIf('admin.carts.relationships.cartCartDetails', ['cartDetails' => $cart->cartCartDetails])
        </div>
    </div>
</div>

@endsection