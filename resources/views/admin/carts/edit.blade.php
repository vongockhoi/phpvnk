@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.cart.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.carts.update", [$cart->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.cart.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('customer_id') ? old('customer_id') : $cart->customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="total_price">{{ trans('cruds.cart.fields.total_price') }}</label>
                <input class="form-control {{ $errors->has('total_price') ? 'is-invalid' : '' }}" type="number" name="total_price" id="total_price" value="{{ old('total_price', $cart->total_price) }}" step="0.01" required>
                @if($errors->has('total_price'))
                    <div class="invalid-feedback">
                        {{ $errors->first('total_price') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.total_price_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="address_id">{{ trans('cruds.cart.fields.address') }}</label>
                <select class="form-control select2 {{ $errors->has('address') ? 'is-invalid' : '' }}" name="address_id" id="address_id" required>
                    @foreach($addresses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('address_id') ? old('address_id') : $cart->address->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('address'))
                    <div class="invalid-feedback">
                        {{ $errors->first('address') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.address_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="coupon_customer_id">{{ trans('cruds.cart.fields.coupon_customer') }}</label>
                <select class="form-control select2 {{ $errors->has('coupon_customer') ? 'is-invalid' : '' }}" name="coupon_customer_id" id="coupon_customer_id">
                    @foreach($coupon_customers as $id => $entry)
                        <option value="{{ $id }}" {{ (old('coupon_customer_id') ? old('coupon_customer_id') : $cart->coupon_customer->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('coupon_customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('coupon_customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.cart.fields.coupon_customer_helper') }}</span>
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
                        if(v == {{ $cart->address->id }}){
                            $('#address_id').append($('<option>', {value: v, text: t}).attr('selected', 'selected'));
                        }else{
                            $('#address_id').append($('<option>', {value: v, text: t}));
                        }
                    });
                },
                error: function(){
                }
            });
        }

    </script>
@endsection
