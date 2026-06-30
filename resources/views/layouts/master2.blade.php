<!DOCTYPE html>
<html>
<head>
    <title>BrandIdea App</title>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <!-- CSRF Token -->
    <meta name="_token" content="{{ csrf_token() }}">
    <link rel="shortcut icon" href="{{ asset('assets/images/bi_favicon.ico') }}">
    <!-- plugin css -->
    <link href="{{ asset('assets/fonts/feather-font/css/iconfont.css') }}" rel="stylesheet" />
    <link href="{{ asset('assets/plugins/perfect-scrollbar/perfect-scrollbar.css') }}" rel="stylesheet" />
    <!-- end plugin css -->
    @stack('plugin-styles')
    <!-- common css -->
    <link href="{{ asset('css/app.css') }}" rel="stylesheet" />
    
    <!-- end common css -->
    @stack('style')
    <style>
        @import url('https://fonts.googleapis.com/css2?family=IBM+Plex+Sans:wght@100;200;300;400;500;600&display=swap');
        body, .main-wrapper .page-wrapper
        {
            background-color: #1c1a17;
            font-family: 'IBM Plex Sans', sans-serif;
        }
        .auth-form-wrapper a
        {
            text-align: center;
        }

        .auth-page .card
        {
            padding: 1rem 1.5rem;
            background-color: #121212;
            border: 1px solid hsla(0,0%,100%,.25098039215686274);
            box-shadow: 0 0 10px 0 rgb(0 0 0 / 20%);
            -webkit-box-shadow: 0 0 10px 0 rgb(255 255 255 / 10%);
        }
        .auth-page .card input
        {
            border:0;
            border-bottom: 1px solid hsla(0,0%,100%,.25098039215686274);
            background-color: transparent;
            display:block;
            font-family: 'IBM Plex Sans', sans-serif;
            padding-right: 0;
            padding-left: 10px;
            color: #fff;
        }
        .custom-control-label
        {
            color:rgba(255,255,255,0.9);
            font-family: 'IBM Plex Sans', sans-serif;
        }
        .auth-page .card button
        {
            color: #fff;
            background-color: #fd7d40;
            border-color: #f26522;
            display: block;
            margin: 0 auto;
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: 400;
            padding: .6rem 1rem .6rem;
            font-size: 16px;
        }
        .auth-page .card button:hover
        {
            background-color: #f26522;
        }
        .email-compose-fields .select2-container--default .select2-selection--multiple:focus, .form-control:focus, .select2-container--default .select2-selection--single .select2-search__field:focus, .select2-container--default .select2-selection--single:focus, .tt-hint:focus, .tt-query:focus, .typeahead:focus, select:focus 
        {
        color: #fff;
        background-color: transparent !important;
        border-color: 1px solid hsla(0,0%,100%,.25098039215686274) !important;
        outline: 0;
        box-shadow: 0 0 0 0.2rem rgb(0 123 255 / 25%);
        }
        .btn-primary:not(:disabled):not(.disabled):active, .swal2-modal .swal2-actions button.swal2-confirm:not(:disabled):not(.disabled):active, .wizard > .actions a:not(:disabled):not(.disabled):active, .btn-primary:not(:disabled):not(.disabled).active, .swal2-modal .swal2-actions button.swal2-confirm:not(:disabled):not(.disabled).active, .wizard > .actions a:not(:disabled):not(.disabled).active, .show > .btn-primary.dropdown-toggle, .swal2-modal .swal2-actions .show > button.dropdown-toggle.swal2-confirm, .wizard > .actions .show > a.dropdown-toggle
        {
            color: #fff;
            background-color: #f26522;
            border-color: #f26522;
        }
        .auth-left-wrapper span
        {
            padding: 3px 6px;
            border-radius: 5px;
            font-style: italic;
            font-size: 14px;
            background-color: #345A64;
            margin-right: 5px;
            color: #fff;
            display: flex;
            align-items: center;
        }
        /* .auth-left-wrapper .col-12 span::before
        {
            width: 10px;
            height: 10px;
            border-radius: 10px;
            background:#DC4302;
            content: '';
            margin-right: 2px;
        } */
        .auth-left-wrapper .col-12
        {
            justify-content: space-between;
            display: flex;
            padding: 0;
            margin: 0 auto;
            align-items: center;
            white-space: nowrap;
            text-align: center;
        }
        .auth-page .card .row .col-md-6:first-child::before
        {
            /* border-right: 1px solid #fff; */
            content: '';
            width: 1px;
            height: 200px;
            background-color: #fff;
            position: absolute;
            right: 0;
            top: 25%;
        }
        .auth-left-wrapper img
        {
            width:100%;
            padding-top: 2.5rem;
        }
        .error
        {
            color: #ff0303;
        }
        @media (max-width: 767px)
        {
            .d-flex
            {
                display: block !important;
                
            }
            .auth-left-wrapper img
            {
                width: 100%;
                padding:0;
            }
            .auth-form-wrapper a img
            {
                width:200px;
            }
            .auth-left-wrapper .col-12
            {
                margin: 0;
            }
            .auth-page .card .row .col-md-7.col-sm-12.col-xs-12
            {
                padding:0;
            }
            .auth-page .card .row .col-md-6:first-child::before
            {
                width:0;
            }
            .auth-left-wrapper span
            {
                font-size: 12px;
            }
        }
    </style>
</head>
<body data-base-url="{{url('/')}}">
    <script src="{{ asset('assets/js/spinner.js') }}"></script>
    <div class="main-wrapper" id="app">
        <div class="page-wrapper full-page">
            @yield('content')
        </div>
    </div>
    <!-- base js -->
    <script src="{{ asset('js/app.js') }}"></script>
    <script src="{{ asset('assets/plugins/feather-icons/feather.min.js') }}"></script>
    <!-- end base js -->
    <!-- plugin js -->
    @stack('plugin-scripts')
    <!-- end plugin js -->
    <!-- common js -->
    <script src="{{ asset('assets/js/template.js') }}"></script>
    <!-- end common js -->
    @stack('custom-scripts')
</body>
</html>