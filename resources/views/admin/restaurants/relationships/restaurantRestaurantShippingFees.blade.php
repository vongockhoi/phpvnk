@can('restaurant_shipping_fee_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.restaurant-shipping-fees.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.restaurantShippingFee.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.restaurantShippingFee.restaurant_shipping_fee_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-restaurantRestaurantShippingFees">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.restaurant') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.district') }}
                        </th>
                        <th>
                            {{ trans('cruds.restaurantShippingFee.fields.shipping_fee') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($restaurantShippingFees as $key => $restaurantShippingFee)
                        <tr data-entry-id="{{ $restaurantShippingFee->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $restaurantShippingFee->id ?? '' }}
                            </td>
                            <td>
                                {{ $restaurantShippingFee->restaurant->name ?? '' }}
                            </td>
                            <td>
                                {{ $restaurantShippingFee->district->name ?? '' }}
                            </td>
                            <td>
                                {{ $restaurantShippingFee->shipping_fee ?? '' }}
                            </td>
                            <td>
                                @can('restaurant_shipping_fee_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.restaurant-shipping-fees.show', $restaurantShippingFee->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('restaurant_shipping_fee_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.restaurant-shipping-fees.edit', $restaurantShippingFee->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('restaurant_shipping_fee_delete')
                                    <form action="{{ route('admin.restaurant-shipping-fees.destroy', $restaurantShippingFee->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('restaurant_shipping_fee_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.restaurant-shipping-fees.massDestroy') }}",
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
  let table = $('.datatable-restaurantRestaurantShippingFees:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection