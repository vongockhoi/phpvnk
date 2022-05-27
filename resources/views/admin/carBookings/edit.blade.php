@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.carBooking.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.car-bookings.update", [$carBooking->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label for="fullname">{{ trans('cruds.carBooking.fields.fullname') }}</label>
                <input class="form-control {{ $errors->has('fullname') ? 'is-invalid' : '' }}" type="text" name="fullname" id="fullname" value="{{ old('fullname', $carBooking->fullname) }}">
                @if($errors->has('fullname'))
                    <div class="invalid-feedback">
                        {{ $errors->first('fullname') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carBooking.fields.fullname_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="phone">{{ trans('cruds.carBooking.fields.phone') }}</label>
                <input class="form-control {{ $errors->has('phone') ? 'is-invalid' : '' }}" type="number" name="phone" id="phone" value="{{ old('phone', $carBooking->phone) }}" step="1" required>
                @if($errors->has('phone'))
                    <div class="invalid-feedback">
                        {{ $errors->first('phone') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carBooking.fields.phone_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="pick_up_point">{{ trans('cruds.carBooking.fields.pick_up_point') }}</label>
                <input class="form-control {{ $errors->has('pick_up_point') ? 'is-invalid' : '' }}" type="text" name="pick_up_point" id="pick_up_point" value="{{ old('pick_up_point', $carBooking->pick_up_point) }}">
                @if($errors->has('pick_up_point'))
                    <div class="invalid-feedback">
                        {{ $errors->first('pick_up_point') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carBooking.fields.pick_up_point_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="destination">{{ trans('cruds.carBooking.fields.destination') }}</label>
                <input class="form-control {{ $errors->has('destination') ? 'is-invalid' : '' }}" type="text" name="destination" id="destination" value="{{ old('destination', $carBooking->destination) }}">
                @if($errors->has('destination'))
                    <div class="invalid-feedback">
                        {{ $errors->first('destination') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carBooking.fields.destination_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time">{{ trans('cruds.carBooking.fields.time') }}</label>
                <input class="form-control datetime {{ $errors->has('time') ? 'is-invalid' : '' }}" type="text" name="time" id="time" value="{{ old('time', $carBooking->time) }}">
                @if($errors->has('time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carBooking.fields.time_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="status_id">{{ trans('cruds.carBooking.fields.status') }}</label>
                <select class="form-control select2 {{ $errors->has('status') ? 'is-invalid' : '' }}" name="status_id" id="status_id" required>
                    @foreach($statuses as $id => $entry)
                        <option value="{{ $id }}" {{ (old('status_id') ? old('status_id') : $carBooking->status->id ?? '') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('status'))
                    <div class="invalid-feedback">
                        {{ $errors->first('status') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.carBooking.fields.status_helper') }}</span>
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