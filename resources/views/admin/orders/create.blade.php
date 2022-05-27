@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('cruds.order.order_create') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.orders.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="code">{{ trans('cruds.order.fields.code') }}</label>
                <input class="form-control {{ $errors->has('code') ? 'is-invalid' : '' }}" type="text" name="code" id="code" value="{{ old('code', '') }}" required>
                @if($errors->has('code'))
                    <div class="invalid-feedback">
                        {{ $errors->first('code') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.code_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.order.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="restaurant_id">{{ trans('cruds.order.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id" required>
                    @foreach($restaurants as $id => $entry)
                        <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('restaurant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total_price">{{ trans('cruds.order.fields.total_price') }}</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', '') }}" step="0.01" required>
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.total_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="address_id">{{ trans('cruds.order.fields.address') }}</label>
                <select class="form-control select2 {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address_id" id="address_id">
                    @foreach($addresses as $id => $entry)
                        <option value="{{ $id }}" {{ old('address_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('cruds.order.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ old('status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.status_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_prepay') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_prepay" value="0">
                    <input class="form-check-input" type="checkbox" name="is_prepay" id="is_prepay" value="1" {{ old('is_prepay', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_prepay">{{ trans('cruds.order.fields.is_prepay') }}</label>
                </div>
                @if($errors->has('is_prepay'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_prepay') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.is_prepay_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_delivery') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_delivery" value="0">
                    <input class="form-check-input" type="checkbox" name="is_delivery" id="is_delivery" value="1" {{ old('is_delivery', 0) == 1 ? 'checked' : '' }}>
                    <label class="form-check-label" for="is_delivery">{{ trans('cruds.order.fields.is_delivery') }}</label>
                </div>
                @if($errors->has('is_delivery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_delivery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.is_delivery_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coupon_customer_id">{{ trans('cruds.order.fields.coupon_customer') }}</label>
                <select class="form-control select2 {{ $errors->has('coupon_customer') ? 'is-invalid' : '' }}" name="coupon_customer_id" id="coupon_customer_id">
                    @foreach($coupon_customers as $id => $entry)
                        <option value="{{ $id }}" {{ old('coupon_customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('coupon_customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coupon_customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.coupon_customer_helper') }}</span>
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

@section('scripts')
    <script>
        $(function () {
            filterAddress();
        })

        $( "#customer_id" ).change(function() {
            filterAddress();
        });

        function filterAddress() {
            var customer_id = $("#customer_id").val();
            $.ajax({
                url: '{{ route("admin.addresses.filterAddressByCustomer") }}',
                data: {
                    customer_id: customer_id
                },
                type: "get",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function(data){
                    console.log(data)
                    $('#address_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Xin hãy lựa chọn</option>')

                    $.each( data, function(v, t) {
                        $('#address_id').append($('<option>', {value: v, text: t}));
                    });
                },
                error: function(){
                }
            });
        }

    </script>
@endsection
