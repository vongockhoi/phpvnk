@extends('layouts.admin')
@section('content')
@can('car_booking_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.car-bookings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.carBooking.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.carBooking.car_booking_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CarBooking">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.fullname') }}
                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.phone') }}
                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.pick_up_point') }}
                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.destination') }}
                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.time') }}
                        </th>
                        <th>
                            {{ trans('cruds.carBooking.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($carBookings as $key => $carBooking)
                        <tr data-entry-id="{{ $carBooking->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $carBooking->id ?? '' }}
                            </td>
                            <td>
                                {{ $carBooking->fullname ?? '' }}
                            </td>
                            <td>
                                {{ $carBooking->phone ?? '' }}
                            </td>
                            <td>
                                {{ $carBooking->pick_up_point ?? '' }}
                            </td>
                            <td>
                                {{ $carBooking->destination ?? '' }}
                            </td>
                            <td>
                                {{ $carBooking->time ?? '' }}
                            </td>
                            <td>
                                {{ $carBooking->status->name ?? '' }}
                            </td>
                            <td>
                                @can('car_booking_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.car-bookings.show', $carBooking->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('car_booking_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.car-bookings.edit', $carBooking->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('car_booking_delete')
                                    <form action="{{ route('admin.car-bookings.destroy', $carBooking->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('car_booking_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.car-bookings.massDestroy') }}",
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
  let table = $('.datatable-CarBooking:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection