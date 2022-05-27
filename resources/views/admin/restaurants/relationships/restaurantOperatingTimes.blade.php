@can('operating_time_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.operating-times.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.operatingTime.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.operatingTime.operating_time_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-restaurantOperatingTimes">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.restaurant') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.open_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.close_time') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.monday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.tuesday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.wednesday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.thursday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.friday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.saturday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.sunday') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.day_off') }}
                        </th>
                        <th>
                            {{ trans('cruds.operatingTime.fields.time_off') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
{{--                    @foreach($operatingTimes as $key => $operatingTime)--}}
                @if(!empty($operatingTime))
                    <tr data-entry-id="{{ $operatingTime->id }}">
                        <td>

                        </td>
                        <td>
                            {{ $operatingTime->id ?? '' }}
                        </td>
                        <td>
                            {{ $operatingTime->restaurant->name ?? '' }}
                        </td>
                        <td>
                            {{ $operatingTime->open_time ?? '' }}
                        </td>
                        <td>
                            {{ $operatingTime->close_time ?? '' }}
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->monday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->monday ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->tuesday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->tuesday ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->wednesday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->wednesday ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->thursday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->thursday ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->friday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->friday ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->saturday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->saturday ? 'checked' : '' }}>
                        </td>
                        <td>
                            <span style="display:none">{{ $operatingTime->sunday ?? '' }}</span>
                            <input type="checkbox" disabled="disabled" {{ $operatingTime->sunday ? 'checked' : '' }}>
                        </td>
                        <td>
                            {{ $operatingTime->day_off ?? '' }}
                        </td>
                        <td>
                            {{ $operatingTime->time_off ?? '' }}
                        </td>
                        <td>
                            @can('operating_time_show')
                                <a class="btn btn-xs btn-primary" href="{{ route('admin.operating-times.show', $operatingTime->id) }}">
                                    {{ trans('global.show') }}
                                </a>
                            @endcan

                            @can('operating_time_edit')
                                <a class="btn btn-xs btn-info" href="{{ route('admin.operating-times.edit', $operatingTime->id) }}">
                                    {{ trans('global.edit') }}
                                </a>
                            @endcan

                            @can('operating_time_delete')
                                <form action="{{ route('admin.operating-times.destroy', $operatingTime->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
                                    <input type="hidden" name="_method" value="DELETE">
                                    <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                    <input type="submit" class="btn btn-xs btn-danger" value="{{ trans('global.delete') }}">
                                </form>
                            @endcan

                        </td>

                    </tr>
                @endif
{{--                    @endforeach--}}
                </tbody>
            </table>
        </div>
    </div>
</div>

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('operating_time_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.operating-times.massDestroy') }}",
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
    pageLength: 10,
  });
  let table = $('.datatable-restaurantOperatingTimes:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection