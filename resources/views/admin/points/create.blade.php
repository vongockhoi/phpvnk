@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.create') }} {{ trans('cruds.point.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.points.store") }}" enctype="multipart/form-data">
            @csrf
            <div class="form-group">
                <label class="required" for="customer_id">{{ trans('cruds.point.fields.customer') }}</label>
                <select class="form-control select2 {{ $errors->has('customer') ? 'is-invalid' : '' }}" name="customer_id" id="customer_id" required>
                    @foreach($customers as $id => $entry)
                        <option value="{{ $id }}" {{ old('customer_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('customer'))
                    <div class="invalid-feedback">
                        {{ $errors->first('customer') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.point.fields.customer_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="num_of_point">{{ trans('cruds.point.fields.num_of_point') }}</label>
                <input class="form-control {{ $errors->has('num_of_point') ? 'is-invalid' : '' }}" type="number" name="num_of_point" id="num_of_point" value="{{ old('num_of_point', '0') }}" step="1" required>
                @if($errors->has('num_of_point'))
                    <div class="invalid-feedback">
                        {{ $errors->first('num_of_point') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.point.fields.num_of_point_helper') }}</span>
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