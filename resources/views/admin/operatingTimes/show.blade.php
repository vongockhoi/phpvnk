@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.operatingTime.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.operating-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.id') }}
                        </th>
                        <td>
                            {{ $operatingTime->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.restaurant') }}
                        </th>
                        <td>
                            {{ $operatingTime->restaurant->name ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.open_time') }}
                        </th>
                        <td>
                            {{ $operatingTime->open_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.close_time') }}
                        </th>
                        <td>
                            {{ $operatingTime->close_time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.monday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->monday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.tuesday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->tuesday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.wednesday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->wednesday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.thursday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->thursday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.friday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->friday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.saturday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->saturday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.sunday') }}
                        </th>
                        <td>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->sunday ? 'checked' : '' }}>
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.day_off') }}
                        </th>
                        <td>
                            {{ $operatingTime->day_off }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.operatingTime.fields.time_off') }}
                        </th>
                        <td>
                            {{ $operatingTime->time_off }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.operating-times.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection