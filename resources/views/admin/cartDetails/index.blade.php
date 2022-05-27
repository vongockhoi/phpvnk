@extends('layouts.admin')
@section('content')
@can('cart_detail_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.cart-details.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.cartDetail.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.cartDetail.cart_detail_list') }}
    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-CartDetail">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.cartDetail.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.cartDetail.fields.cart') }}
                        </th>
                        <th>
                            {{ trans('cruds.cartDetail.fields.product') }}
                        </th>
                        <th>
                            {{ trans('cruds.cartDetail.fields.quantity') }}
                        </th>
                        <th>
                            {{ trans('cruds.cartDetail.fields.note') }}
                        </th>
{{--                        <th>--}}
{{--                            {{ trans('cruds.cartDetail.fields.free_one_product_parent') }}--}}
{{--                        </th>--}}
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($cartDetails as $key => $cartDetail)
                        <tr data-entry-id="{{ $cartDetail->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $cartDetail->id ?? '' }}
                            </td>
                            <td>
                                {{ $cartDetail->cart->total_price ?? '' }}
                            </td>
                            <td>
                                {{ $cartDetail->product->name ?? '' }}
                            </td>
                            <td>
                                {{ $cartDetail->quantity ?? '' }}
                            </td>
                            <td>
                                {{ $cartDetail->note ?? '' }}
                            </td>
{{--                            <td>--}}
{{--                                {{ $cartDetail->free_one_product_parent->name ?? '' }}--}}
{{--                            </td>--}}
                            <td>
                                @can('cart_detail_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.cart-details.show', $cartDetail->id) }}">
                                        {{ trans('global.view') }}
                                    </a>
                                @endcan

                                @can('cart_detail_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.cart-details.edit', $cartDetail->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('cart_detail_delete')
                                    <form action="{{ route('admin.cart-details.destroy', $cartDetail->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('cart_detail_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.cart-details.massDestroy') }}",
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
  let table = $('.datatable-CartDetail:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });
  
})

</script>
@endsection