@extends('layouts.admin')
@section('content')
@can('reservation_status_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.reservation-statuses.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.reservationStatus.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.reservationStatus.reservation_status_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-ReservationStatus">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.reservationStatus.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservationStatus.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservationStatus.fields.description') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservationStatuses as $key => $reservationStatus)
                        <tr data-entry-id="{{ $reservationStatus->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $reservationStatus->id ?? '' }}
                            </td>
                            <td>
                                {{ $reservationStatus->name ?? '' }}
                            </td>
                            <td>
                                {{ $reservationStatus->description ?? '' }}
                            </td>
                            <td>
                                @can('reservation_status_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.reservation-statuses.show', $reservationStatus->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('reservation_status_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.reservation-statuses.edit', $reservationStatus->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('reservation_status_delete')
                                    <form action="{{ route('admin.reservation-statuses.destroy', $reservationStatus->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('reservation_status_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.reservation-statuses.massDestroy') }}",
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
  let table = $('.datatable-ReservationStatus:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection