@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.rating.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ratings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.rating.fields.id') }}
                        </th>
                        <td>
                            {{ $rating->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rating.fields.order') }}
                        </th>
                        <td>
                            {{ $rating->order->id ?? '' }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rating.fields.point_rating') }}
                        </th>
                        <td>
                            {{ $rating->point_rating }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.rating.fields.note') }}
                        </th>
                        <td>
                            {{ $rating->note }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.ratings.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection
