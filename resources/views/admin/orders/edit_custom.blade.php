@extends('layouts.admin')
@section('content')

    <div class="card">
        <div class="card-header">
            {{ trans('cruds.orderDetail.title_singular') }}
        </div>
        <div class="card-body">
            <div class="row text-center">
                <div class="col-sm-12 col-md mb-sm-3 mb-0 text-left ml-3 border-left">
                    <div class="text-muted">{{ trans('cruds.orderDetail.fields.code') }}</div>
                    <strong>{{ $order->code ?? ''}}</strong>
                </div>
                <div class="col-sm-12 col-md mb-sm-3 mb-0 text-left ml-1 border-left">
                    <div class="text-muted">{{ trans('cruds.orderDetail.fields.customer') }}</div>
                    <strong>{{ $order->customer->full_name ?? '' }}</strong>
                </div>
                <div class="col-sm-12 col-md mb-sm-3 mb-0 text-left ml-1 border-left">
                    <div class="text-muted">{{ trans('cruds.orderDetail.fields.customer_phone') }}</div>
                    <strong>{{ $order->customer->phone ?? '' }}</strong>
                </div>
                <div class="col-sm-12 col-md mb-sm-3 mb-0 text-left ml-1 border-left">
                    <div class="text-muted">{{ trans('cruds.orderDetail.fields.restaurant') }}</div>
                    <strong>{{ $order->restaurant->name ?? '' }}</strong>
                </div>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('is_prepay') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="is_prepay" value="0">
                    <input class="form-check-input" type="checkbox" name="is_prepay" id="is_prepay"
                           value="1" {{ $order->is_prepay || old('is_prepay', 0) === 1 ? 'checked' : '' }}>
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
                    <input class="form-check-input" type="checkbox" name="is_delivery" id="is_delivery"
                           value="1" {{ $order->is_delivery || old('is_delivery', 0) === 1 ? 'checked' : '' }}>
                    <label class="form-check-label"
                           for="is_delivery">{{ trans('cruds.order.fields.is_delivery') }}</label>
                </div>
                @if($errors->has('is_delivery'))
                    <div class="invalid-feedback">
                        {{ $errors->first('is_delivery') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.order.fields.is_delivery_helper') }}</span>
            </div>
            <div class="form-group row">
                <label class="col-md-2 col-form-label"
                       for="address_id">{{ trans('cruds.order.fields.address') }}</label>
                <div class="col-md-10">
                    <select class="form-control {{ $errors->has('address') ? 'is-invalid' : '' }}"
                            style="color: #343a40!important" name="address_id"
                            id="address_id">
                        @foreach($addresses as $id => $entry)
                            <option value="{{ $id }}" {{ (old('address_id') ? old('address_id') : $order->address->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach
                    </select>
                    @if($errors->has('address'))
                        <div class="invalid-feedback">
                            {{ $errors->first('address') }}
                        </div>
                    @endif
                    <span class="help-block">{{ trans('cruds.order.fields.address_helper') }}</span>
                </div>
            </div>
            @foreach($order->orderOrderDetails as $index => $orderDetail)
                <hr class="mt-0">
                <div class="form-group row">
                    <div class="col-md-auto">
                        <a href="{{ $orderDetail->product->avatar->getUrl() }}" target="_blank"
                           style="display: inline-block">
                            <img class="rounded-lg" src="{{ $orderDetail->product->avatar->getUrl('thumb') }}">
                        </a>
                    </div>
                    <div class="col-md-4 mb-sm-2 mb-0">
                        <label class="mb-1"
                               for="quantity-{{ $orderDetail->product_id }}"><strong>{{ $orderDetail->product->name ?? '' }}</strong><label
                                    class="text-lowercase mb-1">@if(!empty($orderDetail->product->product_unit))
                                    &nbsp;({{ $orderDetail->product->product_unit->name ?? '' }})@endif</label></label>
                        <p class="mb-0">{{ $orderDetail->product->price_discount ? number_format($orderDetail->product->price_discount) : number_format($orderDetail->product->price) }}
                            đ</p>
                    </div>
                    <input class="col-md-auto form-control col-md-1 text-center"
                           value="{{ old('quantity', $orderDetail->quantity) }}"
                           id="quantity-{{ $orderDetail->product_id }}"
                           type="text"
                           name="quantity"
                           placeholder="quantity"
                           @if($order->status_id != 1)
                           disabled
                           @endif
                           onchange="calculateAmount()">
                    <label class="col-md-4 col-form-label pl-3"
                           for="quantity-{{ $orderDetail->product_id }}">{{ $orderDetail->note ?? '' }}</label>
                    <label class="col-md col-form-label pl-3 text-right"
                           id="price-multiplication-quantity-{{ $orderDetail->product_id }}"
                           for="quantity-{{ $orderDetail->product_id }}">{{ number_format($orderDetail->price_multiplication_quantity) }}
                        đ</label>
                </div>
            @endforeach
            @if(!empty((float) $order->price_ship))
                <hr class="mt-0">
                <div class="form-group row">
                    <label class="col-md col-form-label pl-3"
                           for="text-input"><strong>{{ trans('cruds.orderDetail.fields.shipping_fee') }}</strong></label>
                    <label class="col-md col-form-label pl-3 text-right"
                           for="text-input">{{ number_format($order->price_ship) }} đ</label>
                </div>
            @endif
            <hr class="mt-0">
            <div class="form-group row">
                <label class="col-md col-form-label pl-3"
                       for="text-input"><strong>{{ trans('cruds.orderDetail.fields.total_cost') }}</strong></label>
                <label class="col-md col-form-label pl-3 text-right font-weight-bold" id="total_cost"
                       for="text-input">{{ number_format($order->price_original) }} đ</label>
            </div>
            @if(!empty((float) $order->discount_coupon))
                <hr class="mt-0">
                <div class="form-group">
                    <label for="street"><strong>{{ trans('cruds.orderDetail.fields.promotion') }}</strong></label>
                    <div class="form-group row">
                        <label class="col-md col-form-label pl-3 text-danger"
                               for="text-input">{{ $order->coupon_customer->coupon->name ?? '' }}</label>
                        <label class="col-md col-form-label pl-3 text-right text-danger" id="discount_coupon"
                               for="text-input">- {{ number_format($order->discount_coupon) }} đ</label>
                    </div>
                </div>
            @endif
            <hr class="mt-0">
            <div class="form-group row">
                <label class="col-md col-form-label pl-3"
                       for="text-input"><strong>{{ trans('cruds.orderDetail.fields.amount_to_collect') }}</strong></label>
                <label class="col-md col-form-label pl-3 text-right font-weight-bold h5"
                       style="color: #F9660C!important"
                       id="total_price"
                       for="text-input">{{ number_format($order->total_price) }} đ</label>
            </div>
            @if(!empty((float) $order->deposit_amount))
                <hr class="mt-0">
                <div class="form-group row">
                    <label class="col-md col-form-label pl-3"
                           for="text-input"><strong>{{ trans('cruds.orderDetail.fields.deposited') }}</strong></label>
                    <label class="col-md col-form-label pl-3 text-right font-weight-bold" id="deposited"
                           for="text-input">{{ number_format($order->deposit_amount) }} đ</label>
                </div>
            @endif
        </div>
        @if($order->status_id != 5 && $order->status_id != 6)
            <div class="card-footer text-right">
                @if($order->status_id == 1 || $order->status_id == 2)
                    <button class="btn btn-md btn-danger" onclick="updateCustom(6)"
                            type="reset">{{ trans('global.cancel') }}</button>
                @endif
                @if($order->status_id == 1)
                    <button class="btn btn-md btn-success" type="button" data-toggle="modal"
                            data-target="#primaryModal">{{ trans('global.confirm') }}</button>
                @endif
                @if($order->status_id == 2)
                    <button class="btn btn-md btn-success" onclick="updateCustom(3)"
                            type="submit">{{ trans('global.cooked') }}</button>
                @endif
                @if($order->status_id == 3)
                    <button class="btn btn-md btn-success" onclick="updateCustom(4)"
                            type="submit">{{ trans('global.got') }}</button>
                @endif
                @if($order->status_id == 4)
                    <button class="btn btn-md btn-success" onclick="updateCustom(5)"
                            type="submit">{{ trans('global.completed') }}</button>
                @endif
            </div>
        @endif


        <div class="modal fade" id="primaryModal" tabindex="-1" role="dialog" aria-labelledby="myModalLabel"
             aria-hidden="true">
            <div class="modal-dialog modal-primary" role="document">
                <div class="modal-content">
                    <div class="modal-header">
                        <h4 class="modal-title">{{ trans('cruds.orderDetail.fields.deposit') }}</h4>
                        <button class="close" type="button" data-dismiss="modal" aria-label="Close"><span
                                    aria-hidden="true">×</span></button>
                    </div>
                    <div class="modal-body">
                        <div class="row">
                            <div class="col-sm-12">
                                <div class="form-group form-currency">
                                    <input class="form-control currency_deposit_amount" placeholder="{{ trans('cruds.orderDetail.fields.deposit_placeholder') }}" type="text" name="deposit_amount" id="deposit_amount" step="0.01">
                                    <span class="currency">đ</span>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button class="btn btn-secondary" type="button" data-dismiss="modal">Close</button>
                        @if($order->status_id == 1)
                            <button class="btn btn-md btn-success" onclick="updateCustom(2)"
                                    type="submit">{{ trans('global.confirm') }}</button>
                        @endif
                    </div>
                </div>
                <!-- /.modal-content-->
            </div>
            <!-- /.modal-dialog-->
        </div>
    </div>

@endsection

@section('scripts')
    <script>
        const currency = [2000,1000,500, 200, 100, 50, 20, 10, 5, 2, 1];
        const valueRef = document.querySelector(".currency_deposit_amount");
        function getCurrency(value) {
            console.clear();
            var map = new Map();
            let i = 0;
            //loop unitll value 0
            while (value) {
                //if divide in non-zero add in map
                if (Math.floor(value / currency[i])  != 0) {
                    map.set(currency[i],Math.floor( value / currency[i]));
                    //update value using mod
                    value = value % currency[i];
                }
                i++;
            }

            for (var [key, value] of map) {
                console.log(key + ' = ' + value);
            }
        }
        function getChange() {
            // 48 - 57 (0-9)
            var str1 = valueRef.value;
            if (
                str1[str1.length - 1].charCodeAt() < 48 ||
                str1[str1.length - 1].charCodeAt() > 57
            ) {
                valueRef.value = str1.substring(0, str1.length - 1);
                return;
            }

            // t.replace(/,/g,'')
            let str = valueRef.value.replace(/,/g, "");

            let value = +str;
            getCurrency(value)
            valueRef.value = value.toLocaleString();
        }
        valueRef.addEventListener("keyup", getChange);
    </script>
    <script>
        let dollarUS = Intl.NumberFormat("en-US");

        $(function () {
            filterAddress();
        })

        function filterAddress() {
            var customer_id = {{ $order->customer->id ?? '' }};
            $.ajax({
                url: '{{ route("admin.addresses.filterAddressByCustomer") }}',
                data: {
                    customer_id: customer_id
                },
                type: "get",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    $('#address_id')
                        .find('option')
                        .remove()
                        .end()
                        .append('<option value="">Xin hãy lựa chọn</option>')

                    $.each(data, function (v, t) {
                        if (v == {{ $order->address->id ?? 0 }}) {
                            $('#address_id').append($('<option>', {value: v, text: t}).attr('selected', 'selected'));
                        } else {
                            $('#address_id').append($('<option>', {value: v, text: t}));
                        }
                    });
                },
                error: function () {
                }
            });
        }

        function calculateAmount() {
            let orderId = {{ $order->id }};
            let productArray = [];

            let inputArray = document.getElementsByName('quantity');
            for (let i = 0; i < inputArray.length; i++) {
                let input = inputArray[i];
                let id = input.id;
                let idArray = id.split("-");
                let person = {quantity: input.value, productId: idArray[1]};
                productArray.push(person)
            }

            $.ajax({
                url: '{{ route("admin.orders.calculateAmount") }}',
                data: {
                    orderId: orderId,
                    productArray: productArray,
                },
                type: "post",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function (data) {
                    let total_cost = document.getElementById('total_cost');
                    if (total_cost) {
                        document.getElementById('total_cost').innerHTML = dollarUS.format(data.price_original) + ' đ';
                    }
                    let discount_coupon = document.getElementById('discount_coupon');
                    if (discount_coupon) {
                        document.getElementById('discount_coupon').innerHTML = dollarUS.format(data.discount_coupon) + ' đ';
                    }
                    let total_price = document.getElementById('total_price');
                    if (total_price) {
                        document.getElementById('total_price').innerHTML = dollarUS.format(data.total_price) + ' đ';
                    }
                    let price_multiplication_quantity_Array = data.price_multiplication_quantity;
                    if (!!price_multiplication_quantity_Array.length) {
                        for (let i = 0; i < price_multiplication_quantity_Array.length; i++) {
                            document.getElementById('price-multiplication-quantity-' + price_multiplication_quantity_Array[i].id).innerHTML = dollarUS.format(price_multiplication_quantity_Array[i].price_multiplication_quantity) + ' đ';
                        }
                    }
                },
                error: function () {
                }
            });
        }

        function updateCustom(orderStatus) {
            let orderId = {{ $order->id }};
            let is_prepay = document.getElementById("is_prepay").checked ? 1 : 0;
            let is_delivery = document.getElementById("is_delivery").checked ? 1 : 0;
            let address_id = document.getElementById("address_id").value;
            let deposit_amount = null;
            if(valueRef.value){
                deposit_amount = parseFloat(valueRef.value.replace(/,/g, ""));
            }
            let productArray = [];

            let inputArray = document.getElementsByName('quantity');
            for (let i = 0; i < inputArray.length; i++) {
                let input = inputArray[i];
                let id = input.id;
                let idArray = id.split("-");
                let person = {quantity: input.value, productId: idArray[1]};
                productArray.push(person)
            }

            $.ajax({
                url: '{{ route("admin.orders.updateCustom") }}',
                data: {
                    order_id: orderId,
                    is_prepay: is_prepay,
                    is_delivery: is_delivery,
                    address_id: address_id,
                    status_id: orderStatus,
                    productArray: productArray,
                    deposit_amount: deposit_amount,
                },
                type: "post",
                headers: {
                    'X-CSRF-Token': '{{ csrf_token() }}',
                },
                success: function () {
                    location.reload();
                },
                error: function () {
                }
            });
        }

    </script>

@endsection
