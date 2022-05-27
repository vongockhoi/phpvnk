@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.productUnit.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-units.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.productUnit.fields.id') }}
                        </th>
                        <td>
                            {{ $productUnit->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productUnit.fields.name') }}
                        </th>
                        <td>
                            {{ $productUnit->name }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.productUnit.fields.type') }}
                        </th>
                        <td>
                            {{ App\Models\ProductUnit::TYPE_SELECT[$productUnit->type] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.product-units.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection