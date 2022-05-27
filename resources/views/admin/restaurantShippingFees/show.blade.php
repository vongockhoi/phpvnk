@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.restaurantShippingFee.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.restaurant-shipping-fees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.id') }}
                        </th>
                        <td>
                            {{ $restaurantShippingFee->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.restaurant') }}
                        </th>
                        <td>
                            {{ $restaurantShippingFee->restaurant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.district') }}
                        </th>
                        <td>
                            {{ $restaurantShippingFee->district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.shipping_fee') }}
                        </th>
                        <td>
                            {{ $restaurantShippingFee->shipping_fee }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.restaurant-shipping-fees.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection