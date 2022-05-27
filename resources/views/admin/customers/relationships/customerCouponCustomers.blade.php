@can('coupon_customer_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.coupon-customers.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.couponCustomer.title_singular') }}
            </a>
        </div>
    </div>
@endcan

<div class="card">
    <div class="card-header">
        {{ trans('cruds.couponCustomer.coupon_customer_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-customerCouponCustomers">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.coupon') }}
                        </th>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.couponCustomer.fields.status') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($couponCustomers as $key => $couponCustomer)
                        <tr data-entry-id="{{ $couponCustomer->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $couponCustomer->id ?? '' }}
                            </td>
                            <td>
                                {{ $couponCustomer->code ?? '' }}
                            </td>
                            <td>
                                {{ $couponCustomer->coupon->name ?? '' }}
                            </td>
                            <td>
                                {{ $couponCustomer->customer->phone ?? '' }}
                            </td>
                            <td>
                                {{ $couponCustomer->status->name ?? '' }}
                            </td>
                            <td>
                                @can('coupon_customer_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.coupon-customers.show', $couponCustomer->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('coupon_customer_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.coupon-customers.edit', $couponCustomer->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('coupon_customer_delete')
                                    <form action="{{ route('admin.coupon-customers.destroy', $couponCustomer->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('coupon_customer_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.coupon-customers.massDestroy') }}",
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
  let table = $('.datatable-customerCouponCustomers:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection