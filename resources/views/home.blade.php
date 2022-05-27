@extends('layouts.admin')
@section('content')
    <div class="fade-in">
        <div class="row">
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-primary">
                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-value-lg">{{ $customer_count }}</div>
                            <div>{{ trans('cruds.customer.title_singular') }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas class="chart chartjs-render-monitor" id="card-chart1" height="70"
                                style="display: block; width: 323px; height: 70px;" width="323"></canvas>
                        <div id="card-chart1-tooltip" class="c-chartjs-tooltip top"
                             style="opacity: 0; left: 126.446px; top: 94.2444px;">
                            <div class="c-tooltip-header">
                                <div class="c-tooltip-header-item">March</div>
                            </div>
                            <div class="c-tooltip-body">
                                <div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color"
                                                                       style="background-color: rgb(50, 31, 219);"></span><span
                                            class="c-tooltip-body-item-label">My First dataset</span><span
                                            class="c-tooltip-body-item-value">84</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-info">
                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-value-lg">{{ $order_count }}</div>
                            <div>{{ trans('cruds.order.title_singular') }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas class="chart chartjs-render-monitor" id="card-chart2" height="70" width="323"
                                style="display: block; width: 323px; height: 70px;"></canvas>
                        <div id="card-chart2-tooltip" class="c-chartjs-tooltip top bottom"
                             style="opacity: 0; left: 84.9053px; top: 139.054px;">
                            <div class="c-tooltip-header">
                                <div class="c-tooltip-header-item">January</div>
                            </div>
                            <div class="c-tooltip-body">
                                <div class="c-tooltip-body-item"><span class="c-tooltip-body-item-color"
                                                                       style="background-color: rgb(51, 153, 255);"></span><span
                                            class="c-tooltip-body-item-label">My First dataset</span><span
                                            class="c-tooltip-body-item-value">1</span></div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-warning">
                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-value-lg">{{ $reservation_count }}</div>
                            <div>{{ trans('cruds.reservation.title_singular') }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3" style="height:70px;">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas class="chart chartjs-render-monitor" id="card-chart3" height="70" width="355"
                                style="display: block; width: 355px; height: 70px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
            <div class="col-sm-6 col-lg-3">
                <div class="card text-white bg-danger">
                    <div class="card-body card-body pb-0 d-flex justify-content-between align-items-start">
                        <div>
                            <div class="text-value-lg">{{ $car_booking_count }}</div>
                            <div>{{ trans('cruds.carBooking.title_singular') }}</div>
                        </div>
                    </div>
                    <div class="c-chart-wrapper mt-3 mx-3" style="height:70px;">
                        <div class="chartjs-size-monitor">
                            <div class="chartjs-size-monitor-expand">
                                <div class=""></div>
                            </div>
                            <div class="chartjs-size-monitor-shrink">
                                <div class=""></div>
                            </div>
                        </div>
                        <canvas class="chart chartjs-render-monitor" id="card-chart4" height="70" width="323"
                                style="display: block; width: 323px; height: 70px;"></canvas>
                    </div>
                </div>
            </div>
            <!-- /.col-->
        </div>
        <!-- /.row-->
        <div class="card">
            <div class="card-body">
                <div class="d-flex justify-content-between">
                    <div>
                        <h4 class="card-title mb-0">{{ trans('dashboard.line_charts.title') }}</h4>
                        <div class="small text-muted" style="text-transform:capitalize;">{{$monthNow}}</div>
                    </div>
                    <div class="btn-toolbar d-none d-md-block" role="toolbar" aria-label="Toolbar with buttons">
                        <div class="btn-group btn-group-toggle mx-3" data-toggle="buttons">
                            {{--                            <label class="btn btn-outline-secondary">--}}
                            {{--                                <input id="option1" type="radio" name="options" autocomplete="off"> Day--}}
                            {{--                            </label>--}}
                            <label class="btn btn-outline-secondary active">
                                <input id="option2" type="radio" name="options" autocomplete="off"
                                       checked=""> {{ trans('dashboard.line_charts.date.month') }}
                            </label>
                            {{--                            <label class="btn btn-outline-secondary">--}}
                            {{--                                <input id="option3" type="radio" name="options" autocomplete="off"> Year--}}
                            {{--                            </label>--}}
                        </div>
                    </div>
                </div>
                <div class="c-chart-wrapper" style="height:300px;margin-top:40px;">
                    <div class="chartjs-size-monitor">
                        <div class="chartjs-size-monitor-expand">
                            <div class=""></div>
                        </div>
                        <div class="chartjs-size-monitor-shrink">
                            <div class=""></div>
                        </div>
                    </div>
                    <canvas class="chart chartjs-render-monitor" id="main-chart-custom" height="300" width="1475"
                            style="display: block;"></canvas>

                </div>
                <div>
                    <u><i>Chú thích:</i></u>
                    <ul>
                        <li>Tổng số đơn hàng: <b>{{$total_order_status->total_order}}</b> đơn</li>
                        <li>Trục tung thể hiện số ngày trong tháng</li>
                        <li>Trục hoành thể hiện số đơn hàng trong ngày</li>
                    </ul>
                </div>
            </div>
            <div class="card-footer">
                <div class="row text-center">
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">{{$order_statuses[0]->name}}</div>
                        <strong>{{$total_order_status->status_1}} đơn hàng
                            ({{$total_order_status->status_1 != 0 ? round((($total_order_status->status_1/$total_order_status->total_order)*100),1) : 0}}
                            %)</strong>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-info" role="progressbar"
                                 style="width: {{$total_order_status->status_1 != 0 ? round((($total_order_status->status_1/$total_order_status->total_order)*100),1) : 0}}%"
                                 aria-valuenow="{{$total_order_status->status_1 != 0 ? round((($total_order_status->status_1/$total_order_status->total_order)*100),1) : 0}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">{{$order_statuses[1]->name}}</div>
                        <strong>{{$total_order_status->status_2}} đơn hàng
                            ({{$total_order_status->status_2 != 0 ? round((($total_order_status->status_2/$total_order_status->total_order)*100),1) : 0}}
                            %)</strong>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-success" role="progressbar"
                                 style="width: {{$total_order_status->status_2 != 0 ? round((($total_order_status->status_2/$total_order_status->total_order)*100),1) : 0}}%"
                                 aria-valuenow="{{$total_order_status->status_2 != 0 ? round((($total_order_status->status_2/$total_order_status->total_order)*100),1) : 0}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">{{$order_statuses[2]->name}}</div>
                        <strong>{{$total_order_status->status_3}} đơn hàng
                            ({{$total_order_status->status_3 != 0 ? round((($total_order_status->status_3/$total_order_status->total_order)*100),1) : 0}}
                            %)</strong>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-dark" role="progressbar"
                                 style="width: {{$total_order_status->status_3 != 0 ? round((($total_order_status->status_3/$total_order_status->total_order)*100),1) : 0}}%"
                                 aria-valuenow="{{$total_order_status->status_3 != 0 ? round((($total_order_status->status_3/$total_order_status->total_order)*100),1) : 0}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">{{$order_statuses[3]->name}}</div>
                        <strong>{{$total_order_status->status_4}} đơn hàng
                            ({{$total_order_status->status_4 != 0 ? round((($total_order_status->status_4/$total_order_status->total_order)*100),1) : 0}}
                            %)</strong>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-warning" role="progressbar"
                                 style="width: {{$total_order_status->status_4 != 0 ? round((($total_order_status->status_4/$total_order_status->total_order)*100),1) : 0}}%"
                                 aria-valuenow="{{$total_order_status->status_4 != 0 ? round((($total_order_status->status_4/$total_order_status->total_order)*100),1) : 0}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">{{$order_statuses[4]->name}}</div>
                        <strong>{{$total_order_status->status_5}} đơn hàng
                            ({{$total_order_status->status_5 != 0 ? round((($total_order_status->status_5/$total_order_status->total_order)*100),1) : 0}}
                            %)</strong>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-primary" role="progressbar"
                                 style="width: {{$total_order_status->status_5 != 0 ? round((($total_order_status->status_5/$total_order_status->total_order)*100),1) : 0}}%"
                                 aria-valuenow="{{$total_order_status->status_5 != 0 ? round((($total_order_status->status_5/$total_order_status->total_order)*100),1) : 0}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                    <div class="col-sm-12 col-md mb-sm-2 mb-0">
                        <div class="text-muted">{{$order_statuses[5]->name}}</div>
                        <strong>{{$total_order_status->status_6}} đơn hàng
                            ({{$total_order_status->status_6 != 0 ? round((($total_order_status->status_6/$total_order_status->total_order)*100),1) : 0}}
                            %)</strong>
                        <div class="progress progress-xs mt-2">
                            <div class="progress-bar bg-danger" role="progressbar"
                                 style="width: {{$total_order_status->status_6 != 0 ? round((($total_order_status->status_6/$total_order_status->total_order)*100),1) : 0}}%"
                                 aria-valuenow="{{$total_order_status->status_6 != 0 ? round((($total_order_status->status_6/$total_order_status->total_order)*100),1) : 0}}"
                                 aria-valuemin="0" aria-valuemax="100"></div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- /.card-->
    </div>
@endsection
@section('scripts')
    @parent
    {{--    <script src="{{ asset('js/main2.js') }}"></script>--}}
    <script>
        var order_days = @json($order_days);
        var order_totals = @json($order_totals);
        const mainChart = new Chart(document.getElementById('main-chart-custom'), {
            type: 'line',
            data: {
                labels: handleArray(order_days),
                datasets: [
                    {
                        label: '{{ trans('dashboard.line_charts.line_title') }}',
                        backgroundColor: coreui.Utils.hexToRgba(coreui.Utils.getStyle('--info'), 10),
                        borderColor: coreui.Utils.getStyle('--info'),
                        pointHoverBackgroundColor: '#fff',
                        borderWidth: 2,
                        data: order_totals
                    },
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            drawOnChartArea: false
                        }
                    }],
                    yAxes: [{
                        ticks: {
                            beginAtZero: true,
                            maxTicksLimit: 5,
                            stepSize: Math.ceil(Math.max(...order_totals) / 5),
                            max: Math.max(...order_totals)
                        }
                    }]
                },
                elements: {
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4,
                        hoverBorderWidth: 3
                    }
                }
            }
        })


        //
        Chart.defaults.global.pointHitDetectionRadius = 1
        Chart.defaults.global.tooltips.enabled = false
        Chart.defaults.global.tooltips.mode = 'index'
        Chart.defaults.global.tooltips.position = 'nearest'
        Chart.defaults.global.tooltips.custom = coreui.ChartJS.customTooltips
        Chart.defaults.global.defaultFontColor = '#646470'

        // eslint-disable-next-line no-unused-vars
        var customers = @json($customers);
        var customers_day = _.pluck(customers, 'day');
        var customers_total = _.pluck(customers, 'total');
        const cardChart1 = new Chart(document.getElementById('card-chart1'), {
            type: 'line',
            data: {
                labels: handleArray(customers_day),
                datasets: [
                    {
                        label: 'Tổng khách',
                        backgroundColor: 'transparent',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointBackgroundColor: coreui.Utils.getStyle('--primary'),
                        data: customers_total
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: 'transparent',
                            zeroLineColor: 'transparent'
                        },
                        ticks: {
                            fontSize: 2,
                            fontColor: 'transparent'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                            display: false,
                            min: Math.min(...customers_total),
                            max: Math.max(...customers_total)
                        }
                    }]
                },
                elements: {
                    line: {
                        borderWidth: 1
                    },
                    point: {
                        radius: 4,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        })

        // eslint-disable-next-line no-unused-vars
        var orders = @json($orders);
        var orders_day = _.pluck(orders, 'day');
        var orders_total = _.pluck(orders, 'total');
        const cardChart2 = new Chart(document.getElementById('card-chart2'), {
            type: 'line',
            data: {
                labels: handleArray(orders_day),
                datasets: [
                    {
                        label: 'Tổng đơn',
                        backgroundColor: 'transparent',
                        borderColor: 'rgba(255,255,255,.55)',
                        pointBackgroundColor: coreui.Utils.getStyle('--info'),
                        data: orders_total
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        gridLines: {
                            color: 'transparent',
                            zeroLineColor: 'transparent'
                        },
                        ticks: {
                            fontSize: 2,
                            fontColor: 'transparent'
                        }
                    }],
                    yAxes: [{
                        display: false,
                        ticks: {
                            display: false,
                            min: Math.min(...orders_total),
                            max: Math.max(...orders_total)
                        }
                    }]
                },
                elements: {
                    line: {
                        tension: 0.00001,
                        borderWidth: 1
                    },
                    point: {
                        radius: 4,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        })

        // eslint-disable-next-line no-unused-vars
        var reservations = @json($reservations);
        var reservations_day = _.pluck(reservations, 'day');
        var reservations_total = _.pluck(reservations, 'total');

        const cardChart3 = new Chart(document.getElementById('card-chart3'), {
            type: 'line',
            data: {
                labels: handleArray(reservations_day),
                datasets: [
                    {
                        label: 'Tổng đơn',
                        backgroundColor: 'rgba(255,255,255,.2)',
                        borderColor: 'rgba(255,255,255,.55)',
                        data: reservations_total
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                },
                elements: {
                    line: {
                        borderWidth: 2
                    },
                    point: {
                        radius: 0,
                        hitRadius: 10,
                        hoverRadius: 4
                    }
                }
            }
        })

        // eslint-disable-next-line no-unused-vars
        var car_bookings = @json($car_bookings);
        var car_bookings_day = _.pluck(car_bookings, 'day');
        var car_bookings_total = _.pluck(car_bookings, 'total');
        console.log(car_bookings)

        const cardChart4 = new Chart(document.getElementById('card-chart4'), {
            type: 'bar',
            data: {
                labels: handleArray(car_bookings_day),
                datasets: [
                    {
                        label: 'Tổng đơn',
                        backgroundColor: 'rgba(255,255,255,.2)',
                        borderColor: 'rgba(255,255,255,.55)',
                        data: car_bookings_total,
                        barPercentage: 0.6
                    }
                ]
            },
            options: {
                maintainAspectRatio: false,
                legend: {
                    display: false
                },
                scales: {
                    xAxes: [{
                        display: false
                    }],
                    yAxes: [{
                        display: false
                    }]
                }
            }
        })


        function handleArray(array) {
            var arr = [];
            array.forEach(element => arr.push('Ngày ' + element));
            return arr;
        }

    </script>
@endsection
