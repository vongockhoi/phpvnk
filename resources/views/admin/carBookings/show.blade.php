@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.carBooking.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.car-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.id') }}
                        </th>
                        <td>
                            {{ $carBooking->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.fullname') }}
                        </th>
                        <td>
                            {{ $carBooking->fullname }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.phone') }}
                        </th>
                        <td>
                            {{ $carBooking->phone }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.pick_up_point') }}
                        </th>
                        <td>
                            {{ $carBooking->pick_up_point }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.destination') }}
                        </th>
                        <td>
                            {{ $carBooking->destination }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.time') }}
                        </th>
                        <td>
                            {{ $carBooking->time }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.carBooking.fields.status') }}
                        </th>
                        <td>
                            {{ $carBooking->status->name ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.car-bookings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection