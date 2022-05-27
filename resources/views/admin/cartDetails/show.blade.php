@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.cartDetail.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cart-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.cartDetail.fields.id') }}
                        </th>
                        <td>
                            {{ $cartDetail->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cartDetail.fields.cart') }}
                        </th>
                        <td>
                            {{ $cartDetail->cart->total_price ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cartDetail.fields.product') }}
                        </th>
                        <td>
                            {{ $cartDetail->product->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cartDetail.fields.quantity') }}
                        </th>
                        <td>
                            {{ $cartDetail->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.cartDetail.fields.note') }}
                        </th>
                        <td>
                            {{ $cartDetail->note }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.cartDetail.fields.free_one_product_parent') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $cartDetail->free_one_product_parent->name ?? '' }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.cart-details.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection