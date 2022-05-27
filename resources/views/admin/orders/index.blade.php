@extends('layouts.admin')
@section('content')
    @can('order_create')
        <div style="margin-bottom: 10px;" class="row">
            <div class="col-lg-12">
                <a class="btn btn-success" href="{{ route('admin.orders.create') }}">
                    {{ trans('global.add') }} {{ trans('cruds.order.title_singular') }}
                </a>
            </div>
        </div>
    @endcan
    <div class="card" id="order-list">
        <div class="card-header">
            {{ trans('cruds.order.order_list') }}
        </div>

        <div class="card-body">
            <form action="{{route("admin.orders.index")}}" method="get">
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
                        <select class="form-control select2 select_filter" name="order_status_id" id="order_status_id">
                            @foreach($order_status as $id => $entry)
                                <option value="{{ $id }}" {{ request()->get('order_status_id') == $id ? 'selected' : '' }}>{{ $entry }}</option>
                            @endforeach()
                        </select>
                    </div>
                    <div class="col-lg-2">
                        <select class="form-control select2 select_filter" name="is_delivery" id="is_delivery">
                            <option value="" {{ request()->get('is_delivery') == '' ? 'selected' : '' }}>Chọn loại dịch
                                vụ
                            </option>
                            <option value="1" {{ request()->get('is_delivery') == 1 ? 'selected' : '' }}>Giao hàng
                            </option>
                            <option value="-1" {{ request()->get('is_delivery') == -1 ? 'selected' : '' }}>Tự đến lấy
                            </option>

                            {{--                        <option value="1" {{ request()->get('is_price_change') == 1 ? 'selected' : '' }}>Giao hàng</option>--}}
                            {{--                        <option value="-1" {{ request()->get('is_price_change') == -1 ? 'selected' : '' }}>Tự đến lấy</option>--}}
                        </select>
                    </div>
                </div>
                <div style="margin-top: 10px;" class="row" >
                    <div class="col-lg-7 row">
                        <div class="col-lg-5 row">
                            <label class="col-lg-5 control-sm custom-center" style="padding-left: 15px;">{{ trans('global.from_date') }}</label>
                            <div class="col-lg-7" >
                                <input class="form-control form-control-sm select_date" name="from_date" id="from_date" type="date" value="{{ request()->get('from_date') == $from_date ? $from_date : ''}}" placeholder="MM/DD/YYYY">
                            </div>
                        </div>
                        <div class="col-lg-5 row">
                            <label class="col-lg-2 control-sm custom-center" >{{ trans('global.to_date') }}</label>
                            <div class="col-lg-7">
                                <input class="form-control form-control-sm select_date" name="to_date" id="to_date" type="date" value="{{ request()->get('to_date') == $to_date ? $to_date : '' }}" >
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class=" table table-bordered table-striped table-hover datatable datatable-Order">
                    <thead>
                    <tr>
                        <th width="10">

                        </th>
                        <th>
                            {{ trans('cruds.order.fields.id') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.code') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.restaurant') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.total_price') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.address') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.status') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.is_prepay') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.is_delivery') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.coupon_customer') }}
                        </th>
                        <th>
                            {{ trans('cruds.order.fields.created_at') }}
                        </th>
                        <th>
                            &nbsp;
                        </th>
                    </tr>
                    </thead>
                    <tbody>
                    @foreach($orders as $key => $order)
                        <tr data-entry-id="{{ $order->id }}">
                            <td>

                            </td>
                            <td>
                                {{ $order->id ?? '' }}
                            </td>
                            <td>
                                {{ $order->code ?? '' }}
                            </td>
                            <td>
                                {{ $order->customer->full_name ?? '' }}
                            </td>

                            <td>
                                {{ $order->restaurant->name ?? '' }}
                            </td>
                            <td>
                                {{ $order->total_price ? currency_format($order->total_price) : '' }}
                            </td>
                            <td>
                                {{ $order->address->name ?? '' }}
                            </td>
                            <td>
                                {{ $order->status->name ?? '' }}
                            </td>
                            <td>
                                <span style="display:none">{{ $order->is_prepay ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $order->is_prepay ? 'checked' : '' }}>
                            </td>
                            <td>
                                <span style="display:none">{{ $order->is_delivery ?? '' }}</span>
                                <input type="checkbox" disabled="disabled" {{ $order->is_delivery ? 'checked' : '' }}>
                            </td>
                            <td>
                                {{ $order->coupon_customer->code ?? '' }}
                            </td>
                            <td>
                                {{ $order->created_at ?? '' }}
                            </td>
                            <td>
                                @can('order_show')
                                    <a class="btn btn-xs btn-primary"
                                       href="{{ route('admin.orders.show', $order->id) }}">
                                        {{ trans('global.show') }}
                                    </a>
                                @endcan

                                @can('order_edit')
                                    <a class="btn btn-xs btn-info" href="{{ route('admin.orders.edit', $order->id) }}">
                                        {{ trans('global.edit') }}
                                    </a>
                                @endcan

                                @can('order_delete')
                                    <form action="{{ route('admin.orders.destroy', $order->id) }}" method="POST"
                                          onsubmit="return confirm('{{ trans('global.areYouSure') }}');"
                                          style="display: inline-block;">
                                        <input type="hidden" name="_method" value="DELETE">
                                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                                        <input type="submit" class="btn btn-xs btn-danger"
                                               value="{{ trans('global.delete') }}">
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
            @can('order_delete')
            let deleteButtonTrans = '{{ trans('global.datatables.delete') }}'
            let deleteButton = {
                text: deleteButtonTrans,
                url: "{{ route('admin.orders.massDestroy') }}",
                className: 'btn-danger',
                action: function (e, dt, node, config) {
                    var ids = $.map(dt.rows({selected: true}).nodes(), function (entry) {
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
                            data: {ids: ids, _method: 'DELETE'}
                        })
                            .done(function () {
                                location.reload()
                            })
                    }
                }
            }
            dtButtons.push(deleteButton)
            @endcan

            $.extend(true, $.fn.dataTable.defaults, {
                orderCellsTop: true,
                order: [[1, 'desc']],
                pageLength: 10,
            });
            let table = $('.datatable-Order:not(.ajaxTable)').DataTable({buttons: dtButtons})
            $('a[data-toggle="tab"]').on('shown.bs.tab click', function (e) {
                $($.fn.dataTable.tables(true)).DataTable()
                    .columns.adjust();
            });

        })

    </script>
    <script>
        $('.select_filter').on('change', function () {
            this.form.submit();
        });
        $('.select_date').on('change', function () {
           if(true == dateCheck()){
               this.form.submit();
           }

        });

        function dateCheck()
        {
            let fromDate = document.getElementById('from_date').value;
            let toDate = document.getElementById('to_date').value;
            let eDate = new Date(toDate);
            let sDate = new Date(fromDate);
            if(fromDate != '' && toDate != '' && sDate> eDate)
            {
                let today = new Date();
                document.getElementById("to_date").value = today;
                alert('{{trans('global.error_to_date') }}')
                return false;
            }
            return true;
        }
    </script>
    <style>
        .custom-center{
            text-align: center;
            align-items: center;
            justify-content: center;
            padding: unset;
            margin: inherit;
            display: flex;
        }
    </style>

@endsection
