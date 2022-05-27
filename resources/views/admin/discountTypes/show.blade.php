@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.discountType.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.discount-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.discountType.fields.id') }}
                        </th>
                        <td>
                            {{ $discountType->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.discountType.fields.name') }}
                        </th>
                        <td>
                            {{ $discountType->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.discountType.fields.description') }}
                        </th>
                        <td>
                            {{ $discountType->description }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.discount-types.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection