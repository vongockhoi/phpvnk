@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.couponType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coupon-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.couponType.fields.id') }}
                        </th>
                        <td>
                            {{ $couponType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.couponType.fields.name') }}
                        </th>
                        <td>
                            {{ $couponType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.couponType.fields.description') }}
                        </th>
                        <td>
                            {{ $couponType->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.coupon-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection