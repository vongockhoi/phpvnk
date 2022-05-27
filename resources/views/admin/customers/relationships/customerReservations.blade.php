@can('reservation_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.reservations.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.reservation.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.reservation.reservation_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-customerReservations">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.date') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.time') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.slot') }}
                        </th>
                        <th>
                            {{ trans('cruds.reservation.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($reservations as $key => $reservation)
                        <tr data-entry-id="{{ $reservation->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $reservation->id ?? '' }}
                            </td>
                            <td>
                                {{ $reservation->code ?? '' }}
                            </td>
                            <td>
                                {{ $reservation->customer->phone ?? '' }}
                            </td>
                            <td>
                                {{ $reservation->date ?? '' }}
                            </td>
                            <td>
                                {{ $reservation->time ?? '' }}
                            </td>
                            <td>
                                {{ $reservation->slot ?? '' }}
                            </td>
                            <td>
                                {{ $reservation->status->name ?? '' }}
                            </td>
                            <td>
                                @can('reservation_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.reservations.show', $reservation->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('reservation_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.reservations.edit', $reservation->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('reservation_delete')
                                    <form action="{{ route('admin.reservations.destroy', $reservation->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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

@section('scripts')
@parent
<script>
    $(function () {
  let dtButtons = $.extend(true, [], $.fn.dataTable.defaults.buttons)
@can('reservation_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.reservations.massDestroy') }}",
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
  let table = $('.datatable-customerReservations:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection