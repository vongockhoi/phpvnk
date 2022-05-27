@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.cartDetail.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.cart-details.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="cart_id">{{ trans('cruds.cartDetail.fields.cart') }}</label>
                <select class="form-control select2 {{ $errors->has('cart') ? 'is-invalid' : '' }}" name="cart_id" id="cart_id" required>
                    @foreach($carts as $id => $entry)
                        <option value="{{ $id }}" {{ old('cart_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('cart'))
                    <div class="invalid-feedback">
                        {{ $errors->first('cart') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cartDetail.fields.cart_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="product_id">{{ trans('cruds.cartDetail.fields.product') }}</label>
                <select class="form-control select2 {{ $errors->has('product') ? 'is-invalid' : '' }}" name="product_id" id="product_id" required>
                    @foreach($products as $id => $entry)
                        <option value="{{ $id }}" {{ old('product_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('product'))
                    <div class="invalid-feedback">
                        {{ $errors->first('product') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cartDetail.fields.product_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="quantity">{{ trans('cruds.cartDetail.fields.quantity') }}</label>
                <input class="form-control {{ $errors->has('quantity') ? 'is-invalid' : '' }}" type="number" name="quantity" id="quantity" value="{{ old('quantity', '0') }}" step="1" required>
                @if($errors->has('quantity'))
                    <div class="invalid-feedback">
                        {{ $errors->first('quantity') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cartDetail.fields.quantity_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.cartDetail.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note') }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cartDetail.fields.note_helper') }}</span>
            </div>
{{--            <div class="form-group">--}}
{{--                <label for="free_one_product_parent_id">{{ trans('cruds.cartDetail.fields.free_one_product_parent') }}</label>--}}
{{--                <select class="form-control select2 {{ $errors->has('free_one_product_parent') ? 'is-invalid' : '' }}" name="free_one_product_parent_id" id="free_one_product_parent_id">--}}
{{--                    @foreach($free_one_product_parents as $id => $entry)--}}
{{--                        <option value="{{ $id }}" {{ old('free_one_product_parent_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>--}}
{{--                    @endforeach--}}
{{--                </select>--}}
{{--                @if($errors->has('free_one_product_parent'))--}}
{{--                    <div class="invalid-feedback">--}}
{{--                        {{ $errors->first('free_one_product_parent') }}--}}
{{--                    </div>--}}
{{--                @endif--}}
{{--                <span class="help-block">{{ trans('cruds.cartDetail.fields.free_one_product_parent_helper') }}</span>--}}
{{--            </div>--}}
            <div class="form-group">
                <button class="btn btn-danger" type="submit">
                    {{ trans('global.save') }}
                </button>
            </div>
        </form>
    </div>
</div>



@endsection