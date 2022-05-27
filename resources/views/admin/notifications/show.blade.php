@extends('layouts.admin')
@section('content')

<div class="card">
    <div class="card-header">
        {{ trans('global.show') }} {{ trans('cruds.notification.title') }}
    </div>

    <div class="card-body">
        <div class="form-group">
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.notifications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
            <table class="table table-bordered table-striped">
                <tbody>
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.id') }}
                        </th>
                        <td>
                            {{ $notification->id }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.title') }}
                        </th>
                        <td>
                            {{ $notification->title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.sub_title') }}
                        </th>
                        <td>
                            {{ $notification->sub_title }}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.content') }}
                        </th>
                        <td>
                            {!! $notification->content !!}
                        </td>
                    </tr>
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.target_type') }}
                        </th>
                        <td>
                            {{ App\Models\Notification::TARGET_TYPE_SELECT[$notification->target_type] ?? '' }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.notification.fields.target') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            {{ $notification->target->name ?? '' }}--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.schedule_time') }}
                        </th>
                        <td>
                            {{ $notification->schedule_time }}
                        </td>
                    </tr>
{{--                    <tr>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.notification.fields.icon') }}--}}
{{--                        </th>--}}
{{--                        <td>--}}
{{--                            @if($notification->icon)--}}
{{--                                <a href="{{ $notification->icon->getUrl() }}" target="_blank" style="display: inline-block">--}}
{{--                                    <img src="{{ $notification->icon->getUrl('thumb') }}">--}}
{{--                                </a>--}}
{{--                            @endif--}}
{{--                        </td>--}}
{{--                    </tr>--}}
                    <tr>
                        <th>
                            {{ trans('cruds.notification.fields.status') }}
                        </th>
                        <td>
                            {{ App\Models\Notification::STATUS_SELECT[$notification->status] ?? '' }}
                        </td>
                    </tr>
                </tbody>
            </table>
            <div class="form-group">
                <a class="btn btn-default" href="{{ route('admin.notifications.index') }}">
                    {{ trans('global.back_to_list') }}
                </a>
            </div>
        </div>
    </div>
</div>



@endsection