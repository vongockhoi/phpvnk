@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.edit') }} {{ trans('cruds.rating.title_singular') }}
    </div>

    <div class="card-body">
        <form method="POST" action="{{ route("admin.ratings.update", [$rating->id]) }}" enctype="multipart/form-data">
            @method('PUT')
            @csrf
            <div class="form-group">
                <label class="required" for="order_id">{{ trans('cruds.rating.fields.order') }}</label>
                <select class="form-control select2 {{ $errors->has('order') ? 'is-invalid' : '' }}" name="order_id" id="order_id" required>
                    @foreach($orders as $id => $entry)
                        <option value="{{ $entry }}" {{ (old('order_id') ? old('order_id') : $rating->order->id ?? '') == $entry ? 'selected' : '' }}>{{ $entry }}</option>
                    @endforeach
                </select>
                @if($errors->has('order'))
                    <div class="invalid-feedback">
                        {{ $errors->first('order') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rating.fields.order_helper') }}</span>
            </div>
            <div class="form-group">
                <label class="required" for="point_rating">{{ trans('cruds.rating.fields.point_rating') }}</label>
                <input class="form-control {{ $errors->has('point_rating') ? 'is-invalid' : '' }}" type="number" name="point_rating" id="point_rating" value="{{ old('point_rating', $rating->point_rating) }}" step="1" required>
                @if($errors->has('point_rating'))
                    <div class="invalid-feedback">
                        {{ $errors->first('point_rating') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rating.fields.point_rating_helper') }}</span>
            </div>
            <div class="form-group">
                <label for="note">{{ trans('cruds.rating.fields.note') }}</label>
                <textarea class="form-control {{ $errors->has('note') ? 'is-invalid' : '' }}" name="note" id="note">{{ old('note', $rating->note) }}</textarea>
                @if($errors->has('note'))
                    <div class="invalid-feedback">
                        {{ $errors->first('note') }}
                    </div>
                @endif
                <span class="help-block">{{ trans('cruds.rating.fields.note_helper') }}</span>
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
