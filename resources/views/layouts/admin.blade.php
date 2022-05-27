<!DOCTYPE html>
<html>

<head>
    <meta charset="UTF-8">
    <meta name="viewport"
          content="width=device-width, user-scalable=no, initial-scale=1.0, maximum-scale=1.0, minimum-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ trans('panel.site_title') }}</title>
    <link href="{{ asset('css/bootstrap.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/font-awesome.css') }}" rel="stylesheet"/>
    <link href="https://use.fontawesome.com/releases/v5.2.0/css/all.css" rel="stylesheet"/>
    <link href="{{ asset('css/jquery.dataTables.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dataTables.bootstrap4.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/buttons.dataTables.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/select.dataTables.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/select2.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/bootstrap-datetimepicker.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/dropzone.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/perfect-scrollbar.min.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/custom.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/style.css') }}" rel="stylesheet"/>
    <link href="{{ asset('css/coreui-chartjs.css') }}" rel="stylesheet"/>
    <link rel="icon" type="image/x-icon" href="/image/app-icon-noristaff.png">
    @yield('styles')
</head>

<body class="c-app">
@include('partials.menu')
<div class="c-wrapper">

    <header class="c-header c-header-fixed px-3">
        <button class="c-header-toggler c-class-toggler d-lg-none mfe-auto" type="button" data-target="#sidebar"
                data-class="c-sidebar-show">
            <i class="fas fa-fw fa-bars"></i>
        </button>

        <a class="c-header-brand d-lg-none" href="#">{{ trans('panel.site_title') }}</a>

        <button class="c-header-toggler mfs-3 d-md-down-none" type="button" responsive="true">
            <i class="fas fa-fw fa-bars"></i>
        </button>

        <ul class="c-header-nav ml-auto">
            @if(count(config('panel.available_languages', [])) > 1)
                <li class="c-header-nav-item dropdown d-md-down-none">
                    <a class="c-header-nav-link" data-toggle="dropdown" href="#" role="button" aria-haspopup="true"
                       aria-expanded="false">
                        {{ strtoupper(app()->getLocale()) }}
                    </a>
                    <div class="dropdown-menu dropdown-menu-right">
                        @foreach(config('panel.available_languages') as $langLocale => $langName)
                            <a class="dropdown-item"
                               href="{{ url()->current() }}?change_language={{ $langLocale }}">{{ strtoupper($langLocale) }}
                                ({{ $langName }})</a>
                        @endforeach
                    </div>
                </li>
            @endif
        </ul>

    </header>

    <div class="c-body">
        <main class="c-main">

            <div class="container-fluid">
                @if(session('message'))
                    <div class="row mb-2">
                        <div class="col-lg-12">
                            <div class="alert alert-success" role="alert">{{ session('message') }}</div>
                        </div>
                    </div>
                @endif
                @if($errors->count() > 0)
                    <div class="alert alert-danger">
                        <ul class="list-unstyled">
                            @foreach($errors->all() as $error)
                                <li>{{ $error }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
                @yield('content')

            </div>


        </main>
        <form id="logoutform" action="{{ route('logout') }}" method="POST" style="display: none;">
            {{ csrf_field() }}
        </form>
    </div>
</div>

<script src="{{ asset('js/jquery.min.js') }}"></script>
<script src="{{ asset('js/bootstrap.min.js') }}"></script>
<script src="{{ asset('js/popper.min.js') }}"></script>
<script src="{{ asset('js/perfect-scrollbar.min.js') }}"></script>
<script src="{{ asset('js/coreui.min.js') }}"></script>
<script src="//cdn.datatables.net/1.10.19/js/jquery.dataTables.min.js"></script>
<script src="{{ asset('js/dataTables.bootstrap4.min.js') }}"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/dataTables.buttons.min.js"></script>
<script src="//cdn.datatables.net/buttons/1.2.4/js/buttons.flash.min.js"></script>
<script src="{{ asset('js/buttons.html5.min.js') }}"></script>
<script src="{{ asset('js/buttons.print.min.js') }}"></script>
<script src="{{ asset('js/buttons.colVis.min.js') }}"></script>
<script src="{{ asset('js/pdfmake.min.js') }}"></script>
<script src="{{ asset('js/vfs_fonts.js') }}"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jszip/2.5.0/jszip.min.js"></script>
<script src="{{ asset('js/dataTables.select.min.js') }}"></script>
<script src="{{ asset('js/ckeditor.js') }}"></script>
<script src="{{ asset('js/moment.min.js') }}"></script>
<script src="{{ asset('js/bootstrap-datetimepicker.min.js') }}"></script>
<script src="{{ asset('js/select2.full.min.js') }}"></script>
<script src="{{ asset('js/dropzone.min.js') }}"></script>
<script src="{{ asset('js/main.js') }}"></script>
<script src="{{ asset('js/coreui-chartjs.bundle.js') }}"></script>
<script src="{{ asset('js/coreui-utils.js') }}"></script>
<script>
    $(function () {
        let copyButtonTrans = '{{ trans('global.datatables.copy') }}'
        let csvButtonTrans = '{{ trans('global.datatables.csv') }}'
        let excelButtonTrans = '{{ trans('global.datatables.excel') }}'
        let pdfButtonTrans = '{{ trans('global.datatables.pdf') }}'
        let printButtonTrans = '{{ trans('global.datatables.print') }}'
        let colvisButtonTrans = '{{ trans('global.datatables.colvis') }}'
        let selectAllButtonTrans = '{{ trans('global.select_all') }}'
        let selectNoneButtonTrans = '{{ trans('global.deselect_all') }}'

        let languages = {
            'en': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/English.json',
            'vi': 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Vietnamese.json'
        };

        $.extend(true, $.fn.dataTable.Buttons.defaults.dom.button, {className: 'btn'})
        $.extend(true, $.fn.dataTable.defaults, {
            language: {
                url: languages['{{ app()->getLocale() }}']
            },
            columnDefs: [{
                orderable: false,
                className: 'select-checkbox',
                targets: 0
            }, {
                orderable: false,
                searchable: false,
                targets: -1
            }],
            select: {
                style: 'multi+shift',
                selector: 'td:first-child'
            },
            order: [],
            scrollX: true,
            pageLength: 100,
            dom: 'lBfrtip<"actions">',
            buttons: [
                {
                    extend: 'selectAll',
                    className: 'btn-primary',
                    text: selectAllButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    },
                    action: function (e, dt) {
                        e.preventDefault()
                        dt.rows().deselect();
                        dt.rows({search: 'applied'}).select();
                    }
                },
                {
                    extend: 'selectNone',
                    className: 'btn-primary',
                    text: selectNoneButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'copy',
                    className: 'btn-default',
                    text: copyButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'csv',
                    className: 'btn-default',
                    text: csvButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'excel',
                    className: 'btn-default',
                    text: excelButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'pdf',
                    className: 'btn-default',
                    text: pdfButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'print',
                    className: 'btn-default',
                    text: printButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                },
                {
                    extend: 'colvis',
                    className: 'btn-default',
                    text: colvisButtonTrans,
                    exportOptions: {
                        columns: ':visible'
                    }
                }
            ]
        });

        $.fn.dataTable.ext.classes.sPageButton = '';
    });

</script>
<script>
    $(document).ready(function () {
        $('.searchable-field').select2({
            minimumInputLength: 3,
            ajax: {
                url: '{{ route("admin.globalSearch") }}',
                dataType: 'json',
                type: 'GET',
                delay: 200,
                data: function (term) {
                    return {
                        search: term
                    };
                },
                results: function (data) {
                    return {
                        data
                    };
                }
            },
            escapeMarkup: function (markup) {
                return markup;
            },
            templateResult: formatItem,
            templateSelection: formatItemSelection,
            placeholder: '{{ trans('global.search') }}...',
            language: {
                inputTooShort: function (args) {
                    var remainingChars = args.minimum - args.input.length;
                    var translation = '{{ trans('global.search_input_too_short') }}';

                    return translation.replace(':count', remainingChars);
                },
                errorLoading: function () {
                    return '{{ trans('global.results_could_not_be_loaded') }}';
                },
                searching: function () {
                    return '{{ trans('global.searching') }}';
                },
                noResults: function () {
                    return '{{ trans('global.no_results') }}';
                },
            }

        });

        function formatItem(item) {
            if (item.loading) {
                return '{{ trans('global.searching') }}...';
            }
            var markup = "<div class='searchable-link' href='" + item.url + "'>";
            markup += "<div class='searchable-title'>" + item.model + "</div>";
            $.each(item.fields, function (key, field) {
                markup += "<div class='searchable-fields'>" + item.fields_formated[field] + " : " + item[field] + "</div>";
            });
            markup += "</div>";

            return markup;
        }

        function formatItemSelection(item) {
            if (!item.model) {
                return '{{ trans('global.search') }}...';
            }
            return item.model;
        }

        $(document).delegate('.searchable-link', 'click', function () {
            var url = $(this).attr('href');
            window.location = url;
        });
    });

</script>

<script src="{{ asset('js/firebase-app.js') }}"></script>
<script src="{{ asset('js/firebase-messaging.js') }}"></script>

<script>
    var firebaseConfig = {
        apiKey: "AIzaSyA7HHDo6ZVY5omFS3Q3STT1MLvzkUgecQQ",
        authDomain: "nori-food.firebaseapp.com",
        databaseURL: "https://nori-food.firebaseio.com",
        projectId: "nori-food",
        storageBucket: "nori-food.appspot.com",
        messagingSenderId: "466567384802",
        appId: "1:466567384802:web:ccd98ec6a25f52099018bb",
        measurementId: "G-N65BCB1MHH"
    };

    firebase.initializeApp(firebaseConfig);
    const messaging = firebase.messaging();

    messaging.getToken({vapidKey: 'BKWjI5F_1230ZI9rcXrq0Xzns0vj3SXzv0WGlvIAthFu143nEb3W4GbtQqXjN4TIK9BmL9az7QNkAQc_dUtuvy0'}).then((currentToken) => {
        if (currentToken) {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
            });
            $.ajax({
                url: '{{ route("admin.updateMessageTokenFirebase") }}',
                type: 'POST',
                data: {
                    token: currentToken
                },
                dataType: 'JSON'
            });
        } else {
            // Show permission request UI
            console.log('No registration token available. Request permission to generate one.');
        }
    }).catch((err) => {
        console.log('An error occurred while retrieving token. ', err);
    });

    messaging.onMessage((payload) => {
        const title = payload.notification.title;
        const options = {
            body: payload.notification.body
        };
        new Notification(title, options);
        if (parseInt(payload.data.notificationType) === 1) {
            if (parseInt(payload.data.status) === 1) {
                playSound("{{ asset('new-order.mp3') }}")
                countNewOrder()
            } else if (parseInt(payload.data.status) === 6) {
                playSound("{{ asset('order-reservation-cancelled.mp3') }}")
            }
            if ($("#order-list").length) {
                setTimeout(reloadPageForCount, 4000);
            }
        } else if (parseInt(payload.data.notificationType) === 2) {
            if (parseInt(payload.data.status) === 1) {
                playSound("{{ asset('new-reservation.mp3') }}")
                countNewReservation()
            } else if (parseInt(payload.data.status) === 3) {
                playSound("{{ asset('order-reservation-cancelled.mp3') }}")
            }
            if ($("#reservation-list").length) {
                setTimeout(reloadPageForCount, 4000);
            }
        }
    });

    function reloadPageForCount() {
        location.reload();
    }

</script>
<script>

    $(function () {
        countNewOrder();
        countNewReservation();
    })

    function countNewOrder() {
        $.ajax({
            url: '{{ route("admin.orders.countNewOrder") }}',
            data: {},
            type: "get",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function (data) {
                if (data > 0) {
                    if ($("#count-new-order")[0]) {
                        if ($("#count-new-order").is(".badge.badge-pill.badge-danger")) {
                            $("#count-new-order").text(data);
                        } else {
                            $("#count-new-order").addClass("badge badge-pill badge-danger");
                            $("#count-new-order").text(data);
                        }
                    }
                } else {
                    $("#count-new-order").removeClass("badge badge-pill badge-danger");
                    $("#count-new-order").text('');
                }
            }
        });
    }

    function countNewReservation() {
        $.ajax({
            url: '{{ route("admin.reservations.countNewReservation") }}',
            data: {},
            type: "get",
            headers: {
                'X-CSRF-Token': '{{ csrf_token() }}',
            },
            success: function (data) {
                if (data > 0) {
                    if ($("#count-new-reservation")[0]) {
                        if ($("#count-new-reservation").is(".badge.badge-pill.badge-danger")) {
                            $("#count-new-reservation").text(data);
                        } else {
                            $("#count-new-reservation").addClass("badge badge-pill badge-danger");
                            $("#count-new-reservation").text(data);
                        }
                    }
                } else {
                    $("#count-new-reservation").removeClass("badge badge-pill badge-danger");
                    $("#count-new-reservation").text('');
                }
            }
        });
    }

    function playSound(url) {
        var audioElement = document.createElement('audio');
        audioElement.setAttribute('src', url);
        audioElement.setAttribute("autoplay", "");
        audioElement.setAttribute('muted', 'muted');
        audioElement.play();
    }

</script>
@yield('scripts')
</body>

</html>
