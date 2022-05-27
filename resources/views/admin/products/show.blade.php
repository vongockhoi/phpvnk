@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.product.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.id') }}
                        </th>
                        <td>
                            {{ $product->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.name') }}
                        </th>
                        <td>
                            {{ $product->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.avatar') }}
                        </th>
                        <td>
                            @if($product->avatar)
                                <a href="{{ $product->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $product->avatar->getUrl('thumb') }}">
                                </a>
                            @endif
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.brief_description') }}
                        </th>
                        <td>
                            {{ $product->brief_description }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.hash_tag') }}
                        </th>
                        <td>
                            @foreach($product->hash_tags as $key => $hash_tag)
                                <span class="badge badge-info">{{ $hash_tag->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.restaurant') }}
                        </th>
                        <td>
                            @foreach($product->restaurants as $key => $restaurant)
                                <span class="badge badge-info">{{ $restaurant->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.featured_image') }}
                        </th>
                        <td>
                            @foreach($product->featured_image as $key => $media)
                                <a href="{{ $media->getUrl() }}" target="_blank" style="display: inline-block">
                                    <img src="{{ $media->getUrl('thumb') }}">
                                </a>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.description') }}
                        </th>
                        <td>
                            {!! $product->description !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.category') }}
                        </th>
                        <td>
                            @foreach($product->categories as $key => $category)
                                <span class="badge badge-info">{{ $category->name }}</span>
                            @endforeach
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.preparation_time') }}
                        </th>
                        <td>
                            {{ minuteToTimeText($product->preparation_time) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.price') }}
                        </th>
                        <td>
                            {{ currency_format($product->price) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.price_discount') }}
                        </th>
                        <td>
                            {{ currency_format($product->price_discount) }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.is_price_change') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $product->is_price_change ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
{{--                        <th>--}}
{{--                            {{ trans('cruds.product.fields.type') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $product->type == 1 ? 'Bán theo phần' : $product->type == 2 ? 'Bán theo con' : 'Bán theo kg' }}--}}
{{--                        </td>--}}
                        <th>
                            {{ trans('cruds.product.fields.product_unit_id') }}
                        </th>
                        <td>
                            {{ $product->product_unit->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.quantity') }}
                        </th>
                        <td>
                            {{ $product->quantity }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.product.fields.status') }}
                        </th>
                        <td>
                            {{ $product->status->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.products.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
