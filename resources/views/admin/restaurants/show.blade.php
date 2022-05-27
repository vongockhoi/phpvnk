@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.restaurant.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.restaurants.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.id') }}
                        </th>
                        <td>
                            {{ $restaurant->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.name') }}
                        </th>
                        <td>
                            {{ $restaurant->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.avatar') }}
                        </th>
                        <td>
                            @if($restaurant->avatar)
                                <a href="{{ $restaurant->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $restaurant->avatar->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.province') }}
                        </th>
                        <td>
                            {{ $restaurant->province->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.district') }}
                        </th>
                        <td>
                            {{ $restaurant->district->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.address') }}
                        </th>
                        <td>
                            {{ $restaurant->address }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.status') }}
                        </th>
                        <td>
                            {{ $restaurant->status->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.latitude') }}
                        </th>
                        <td>
                            {{ $restaurant->latitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.longitude') }}
                        </th>
                        <td>
                            {{ $restaurant->longitude }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.featured_image') }}
                        </th>
                        <td>
                            @foreach($restaurant->featured_image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.description') }}
                        </th>
                        <td>
                            {!! $restaurant->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.restaurant.fields.hotline') }}
                        </th>
                        <td>
                            {{ $restaurant->hotline }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.restaurants.index') }}">
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
            <a class="nav-link" href="#restaurant_restaurant_shipping_fees" role="tab" data-toggle="tab">
                {{ trans('cruds.restaurantShippingFee.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#restaurant_operating_times" role="tab" data-toggle="tab">
                {{ trans('cruds.operatingTime.title') }}
            </a>
        </li>
        <li class="nav-item">
            <a class="nav-link" href="#restaurant_products" role="tab" data-toggle="tab">
                {{ trans('cruds.product.title') }}
            </a>
        </li>
    </ul>
    <div class="tab-content">
        <div class="tab-pane" role="tabpanel" id="restaurant_restaurant_shipping_fees">
            @includeIf('admin.restaurants.relationships.restaurantRestaurantShippingFees', ['restaurantShippingFees' => $restaurant->restaurantRestaurantShippingFees])
        </div>
        <div class="tab-pane" role="tabpanel" id="restaurant_operating_times">
            @includeIf('admin.restaurants.relationships.restaurantOperatingTimes', ['operatingTime' => $restaurant->restaurantOperatingTimes])
        </div>
        <div class="tab-pane" role="tabpanel" id="restaurant_products">
            @includeIf('admin.restaurants.relationships.restaurantProducts', ['products' => $restaurant->restaurantProducts])
        </div>
    </div>
</div>

@endsection
