@extends('layouts.admin')
@section('content')
@can('notification_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.notifications.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.notification.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.notification.notification_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Notification">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.notification.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.notification.fields.title') }}
                        </th>
                        <th>
                            {{ trans('cruds.notification.fields.sub_title') }}
                        </th>
                        <th>
                            {{ trans('cruds.notification.fields.target_type') }}
                        </th>
{{--                        <th>--}}
{{--                            {{ trans('cruds.notification.fields.target') }}--}}
{{--                        </th>--}}
                        <th>
                            {{ trans('cruds.notification.fields.schedule_time') }}
                        </th>
{{--                        <th>--}}
{{--                            {{ trans('cruds.notification.fields.icon') }}--}}
{{--                        </th>--}}
                        <th>
                            {{ trans('cruds.notification.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($notifications as $key => $notification)
                        <tr data-entry-id="{{ $notification->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $notification->id ?? '' }}
                            </td>
                            <td>
                                {{ $notification->title ?? '' }}
                            </td>
                            <td>
                                {{ $notification->sub_title ?? '' }}
                            </td>
                            <td>
                                {{ App\Models\Notification::TARGET_TYPE_SELECT[$notification->target_type] ?? '' }}
                            </td>
{{--                            <td>--}}
{{--                                {{ $notification->target->name ?? '' }}--}}
{{--                            </td>--}}
                            <td>
                                {{ $notification->schedule_time ?? '' }}
                            </td>
{{--                            <td>--}}
{{--                                @if($notification->icon)--}}
{{--                                    <a href="{{ $notification->icon->getUrl() }}" target="_blank" style="display: inline-block">--}}
{{--                                        <img src="{{ $notification->icon->getUrl('thumb') }}">--}}
{{--                                    </a>--}}
{{--                                @endif--}}
{{--                            </td>--}}
                            <td>
                                {{ App\Models\Notification::STATUS_SELECT[$notification->status] ?? '' }}
                            </td>
                            <td>
                                @can('notification_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.notifications.show', $notification->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('notification_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.notifications.edit', $notification->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('notification_delete')
                                    <form action="{{ route('admin.notifications.destroy', $notification->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                    </form>
                                @endcan

                            </td>

                        </tr>
                    @endforeach
                </tbody>
            </table>
        </div>
    </div>
</div>



@endsection
@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('notification_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.notifications.massDestroy') }}",
    className: 'btn-danger',
    action: function (e, dt, node, config) {
      var ids = $.map(dt.rows({ selected: true }).nodes(), function (entry) {
          return $(entry).data('entry-id')
      });

      if (ids.length === 0) {
        alert('{{ trans('global.datatables.zero_selected') }}')

        return
      }

      if (confirm('{{ trans('global.areYouSure') }}')) {
        $.ajax({
          headers: {'x-csrf-token': _token},
          method: 'POST',
          url: config.url,
          data: { ids: ids, _method: 'DELETE' }})
          .done(function () { location.reload() })
      }
    }
  }
  dtButtons.push(deleteButton)
@endcan

  $.extend(true, $.fn.dataTable.defaults, {
    orderCellsTop: true,
    order: [[ 1, 'desc' ]],
    pageLength: 100,
  });
  let table = $('.datatable-Notification:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection