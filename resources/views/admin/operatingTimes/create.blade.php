@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.operatingTime.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.operating-times.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="restaurant_id">{{ trans('cruds.operatingTime.fields.restaurant') }}</label>
                <select class="form-control select2 {{ $errors->has('restaurant') ? 'is-invalid' : '' }}" name="restaurant_id" id="restaurant_id" required>
                    @foreach($restaurants as $id => $entry)
                        <option value="{{ $id }}" {{ old('restaurant_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('restaurant'))
                    <div class="invalid-feedback">
                        {{ $errors->first('restaurant') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.restaurant_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="open_time">{{ trans('cruds.operatingTime.fields.open_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('open_time') ? 'is-invalid' : '' }}" type="text" name="open_time" id="open_time" value="{{ old('open_time') }}" required>
                @if($errors->has('open_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('open_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.open_time_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="close_time">{{ trans('cruds.operatingTime.fields.close_time') }}</label>
                <input class="form-control timepicker {{ $errors->has('close_time') ? 'is-invalid' : '' }}" type="text" name="close_time" id="close_time" value="{{ old('close_time') }}" required>
                @if($errors->has('close_time'))
                    <div class="invalid-feedback">
                        {{ $errors->first('close_time') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.close_time_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('monday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="monday" value="0">
                    <input class="form-check-input" type="checkbox" name="monday" id="monday" value="1" {{ old('monday', 0) == 1 || old('monday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="monday">{{ trans('cruds.operatingTime.fields.monday') }}</label>
                </div>
                @if($errors->has('monday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('monday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.monday_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('tuesday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="tuesday" value="0">
                    <input class="form-check-input" type="checkbox" name="tuesday" id="tuesday" value="1" {{ old('tuesday', 0) == 1 || old('tuesday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="tuesday">{{ trans('cruds.operatingTime.fields.tuesday') }}</label>
                </div>
                @if($errors->has('tuesday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('tuesday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.tuesday_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('wednesday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="wednesday" value="0">
                    <input class="form-check-input" type="checkbox" name="wednesday" id="wednesday" value="1" {{ old('wednesday', 0) == 1 || old('wednesday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="wednesday">{{ trans('cruds.operatingTime.fields.wednesday') }}</label>
                </div>
                @if($errors->has('wednesday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('wednesday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.wednesday_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('thursday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="thursday" value="0">
                    <input class="form-check-input" type="checkbox" name="thursday" id="thursday" value="1" {{ old('thursday', 0) == 1 || old('thursday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="thursday">{{ trans('cruds.operatingTime.fields.thursday') }}</label>
                </div>
                @if($errors->has('thursday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('thursday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.thursday_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('friday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="friday" value="0">
                    <input class="form-check-input" type="checkbox" name="friday" id="friday" value="1" {{ old('friday', 0) == 1 || old('friday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="friday">{{ trans('cruds.operatingTime.fields.friday') }}</label>
                </div>
                @if($errors->has('friday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('friday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.friday_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('saturday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="saturday" value="0">
                    <input class="form-check-input" type="checkbox" name="saturday" id="saturday" value="1" {{ old('saturday', 0) == 1 || old('saturday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="saturday">{{ trans('cruds.operatingTime.fields.saturday') }}</label>
                </div>
                @if($errors->has('saturday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('saturday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.saturday_helper') }}</span>
            </div>
            <div class="form-group">
                <div class="form-check {{ $errors->has('sunday') ? 'is-invalid' : '' }}">
                    <input type="hidden" name="sunday" value="0">
                    <input class="form-check-input" type="checkbox" name="sunday" id="sunday" value="1" {{ old('sunday', 0) == 1 || old('sunday') === null ? 'checked' : '' }}>
                    <label class="form-check-label" for="sunday">{{ trans('cruds.operatingTime.fields.sunday') }}</label>
                </div>
                @if($errors->has('sunday'))
                    <div class="invalid-feedback">
                        {{ $errors->first('sunday') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.sunday_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="day_off">{{ trans('cruds.operatingTime.fields.day_off') }}</label>
                <input class="form-control date {{ $errors->has('day_off') ? 'is-invalid' : '' }}" type="text" name="day_off" id="day_off" value="{{ old('day_off') }}">
                @if($errors->has('day_off'))
                    <div class="invalid-feedback">
                        {{ $errors->first('day_off') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.day_off_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="time_off">{{ trans('cruds.operatingTime.fields.time_off') }}</label>
                <input class="form-control timepicker {{ $errors->has('time_off') ? 'is-invalid' : '' }}" type="text" name="time_off" id="time_off" value="{{ old('time_off') }}">
                @if($errors->has('time_off'))
                    <div class="invalid-feedback">
                        {{ $errors->first('time_off') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.operatingTime.fields.time_off_helper') }}</span>
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