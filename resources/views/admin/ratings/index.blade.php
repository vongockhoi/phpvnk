@extends('layouts.admin')
@section('content')
@can('rating_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.ratings.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.rating.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.rating.rating_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Rating">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.rating.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.rating.fields.order') }}
                        </th>
                        <th>
                            {{ trans('cruds.rating.fields.point_rating') }}
                        </th>
                        <th>
                            {{ trans('cruds.rating.fields.note') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($ratings as $key => $rating)
                        <tr data-entry-id="{{ $rating->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $rating->id ?? '' }}
                            </td>
                            <td>
                                {{ $rating->order->id ?? '' }}
                            </td>
                            <td>
                                {{ $rating->point_rating ?? '' }}
                            </td>
                            <td>
                                {{ $rating->note ?? '' }}
                            </td>
                            <td>
                                @can('rating_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.ratings.show', $rating->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('rating_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.ratings.edit', $rating->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('rating_delete')
                                    <form action="{{ route('admin.ratings.destroy', $rating->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('rating_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.ratings.massDestroy') }}",
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
  let table = $('.datatable-Rating:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
@endsection
