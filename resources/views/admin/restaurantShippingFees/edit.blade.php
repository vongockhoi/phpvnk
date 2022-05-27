@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.restaurantShippingFee.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.restaurant-shipping-fees.update", [$restaurantShippingFee->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="restaurant_id">{{ trans('cruds.restaurantShippingFee.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id" required>
                    @foreach($restaurants as $id => $entry)
                        <option value="{{ $id }}" {{ (old('restaurant_id') ? old('restaurant_id') : $restaurantShippingFee->restaurant->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('restaurant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.restaurantShippingFee.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="district_id">{{ trans('cruds.restaurantShippingFee.fields.district') }}</label>
                <select class="form-control select2 {{ $errors->has('district') ? 'is-invalid' : '' }}" name="district_id" id="district_id" required>
                    @foreach($districts as $id => $entry)
                        <option value="{{ $id }}" {{ (old('district_id') ? old('district_id') : $restaurantShippingFee->district->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('district'))
                    <div class="invalid-feedback">
                        {{ $errors->first('district') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.restaurantShippingFee.fields.district_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="shipping_fee">{{ trans('cruds.restaurantShippingFee.fields.shipping_fee') }}</label>
                <input class="form-control {{ $errors->has('shipping_fee') ? 'is-invalid' : '' }}" type="number" name="shipping_fee" id="shipping_fee" value="{{ old('shipping_fee', $restaurantShippingFee->shipping_fee) }}" step="0.01" required>
                @if($errors->has('shipping_fee'))
                    <div class="invalid-feedback">
                        {{ $errors->first('shipping_fee') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.restaurantShippingFee.fields.shipping_fee_helper') }}</span>
            </div>
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection