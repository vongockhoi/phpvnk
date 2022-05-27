@extends('layouts.admin')
@section('content')
@can('product_create')
    <div style="margin-bottom: 10px;" class="row">
        <div class="col-lg-12">
            <a class="btn btn-success" href="{{ route('admin.products.create') }}">
                {{ trans('global.add') }} {{ trans('cruds.product.title_singular') }}
            </a>
        </div>
    </div>
@endcan
<div class="card">
    <div class="card-header">
        {{ trans('cruds.product.product_list') }}
    </div>
    <div class="card-body">
        <form action="{{route("admin.products.index")}}" method="get">
            @csrf
            <div class="row">
                <div class="col-lg-2">
                    <select class="form-control select2 select_filter" name="restaurant_id" id="restaurant_id">
                        @foreach($restaurants as $id => $entry)
                            <option value="{{ $id }}" {{ request()->get('restaurant_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach()
                    </select>
                </div>
                <div class="col-lg-2">
                    <select class="form-control select2 select_filter" name="product_category_id" id="product_category_id">
                        @foreach($categories as $id => $entry)
                            <option value="{{ $id }}" {{ request()->get('product_category_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach()
                    </select>
                </div>
                <div class="col-lg-2">
                    <select class="form-control select2 select_filter" name="is_price_change" id="is_price_change">
                        <option value="" {{ request()->get('is_price_change') == '' ? 'selected' : '' }}>Giá món ăn thay đổi</option>
                        <option value="-1" {{ request()->get('is_price_change') == -1 ? 'selected' : '' }}>Không đổi</option>
                        <option value="1" {{ request()->get('is_price_change') == 1 ? 'selected' : '' }}>Thay đổi</option>
                    </select>
                </div>
                <div class="col-lg-2">
{{--                    <select class="form-control select2 select_filter" name="type" id="type">--}}
{{--                        <option value="" {{ request()->get('type') == '' ? 'selected' : '' }}>Chọn loại bán</option>--}}
{{--                        <option value="1" {{ request()->get('type') == 1 ? 'selected' : '' }}>Theo phần</option>--}}
{{--                        <option value="2" {{ request()->get('type') == 2 ? 'selected' : '' }}>Theo con</option>--}}
{{--                        <option value="3" {{ request()->get('type') == 3 ? 'selected' : '' }}>Theo kg</option>--}}
{{--                    </select>--}}
                    <select class="form-control select2 select_filter" name="product_unit_id" id="product_unit_id">
                        @foreach($product_units as $id => $entry)
                            <option value="{{ $id }}" {{ request()->get('product_unit_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                        @endforeach()
                    </select>
                </div>

                <div class="col-lg-2">
                    <select class="form-control select2 select_filter" name="price_discount" id="price_discount">
                        <option value="" {{ request()->get('price_discount') == '' ? 'selected' : '' }}>Món có giảm giá</option>
                        <option value="-1" {{ request()->get('price_discount') == -1 ? 'selected' : '' }}>Không giảm</option>
                        <option value="1" {{ request()->get('price_discount') == 1 ? 'selected' : '' }}>Có giảm</option>
                    </select>
                </div>
            </div>
        </form>

    </div>

    <div class="card-body">
        <div class="table-responsive">
            <table class=" table table-bordered table-striped table-hover datatable datatable-Product">
                <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.product.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.name') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.avatar') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.category') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.price') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.price_discount') }}
                        </th>
{{--                        <th>--}}
{{--                            {{ trans('cruds.product.fields.quantity') }}--}}
{{--                        </th>--}}
{{--                        <th>--}}
{{--                            {{ trans('cruds.product.fields.status') }}--}}
{{--                        </th>--}}
                        <th>
                            {{ trans('cruds.product.fields.is_price_change') }}
                        </th>
                        <th>
                            {{ trans('cruds.product.fields.restaurant') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                </thead>
                <tbody>
                    @foreach($products as $key => $product)
                        <tr data-entry-id="{{ $product->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $product->id ?? '' }}
                            </td>
                            <td>
                                {{ $product->name ?? '' }}
                            </td>
                            <td>
                                @if($product->avatar)
                                    <a href="{{ $product->avatar->getUrl() }}" target="_blank" style="display: inline-block">
                                        <img src="{{ $product->avatar->getUrl('thumb') }}">
                                    </a>
                                @endif
                            </td>
                            <td>
                                @foreach($product->categories as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                {{ currency_format($product->price) ?? '' }}
                            </td>
                            <td>
                                {{ currency_format($product->price_discount) ?? '' }}
                            </td>
{{--                            <td>--}}
{{--                                {{ $product->quantity ?? '' }}--}}
{{--                            </td>--}}
{{--                            <td>--}}
{{--                                {{ $product->status->name ?? '' }}--}}
{{--                            </td>--}}
                            <td>
                                <span style="display:none">{{ $product->is_price_change ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $product->is_price_change ? 'checked' : '' }}>
                            </td>
                            <td>
                                @foreach($product->restaurants as $key => $item)
                                    <span class="badge badge-info">{{ $item->name }}</span>
                                @endforeach
                            </td>
                            <td>
                                @can('product_show')
                                    <a class="btn btn-xs btn-primary" href="{{ route('admin.products.show', $product->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('product_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.products.edit', $product->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('product_delete')
                                    <form action="{{ route('admin.products.destroy', $product->id) }}" method="POST" onsubmit="return confirm('{{ trans('global.areYouSure') }}');" style="display: inline-block;">
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
@can('product_delete')
  let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
  let deleteButton = {
    text: deleteButtonTrans,
    url: "{{ route('admin.products.massDestroy') }}",
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
  let table = $('.datatable-Product:not(.ajaxTable)').DataTable({ buttons: dtButtons })
  $('a[data-toggle="tab"]').on('shown.bs.tab click', function(e){
      $($.fn.dataTable.tables(true)).DataTable()
          .columns.adjust();
  });

})

</script>
<script>
    $('.select_filter').on('change', function() {
        this.form.submit();
    });
</script>
@endsection
