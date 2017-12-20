@php($get_app_configuration = \App\Master_app_configuration::first())
<!DOCTYPE html>
<html lang="{{ app()->getLocale() }}">
    <base href="{{URL::asset('/')}}" target="_top">
    <head>
        <meta charset="utf-8">
        <meta http-equiv="X-UA-Compatible" content="IE=edge">
        <meta name="viewport" content="width=device-width, initial-scale=1">
        <title>{{ config('app.name') }}</title>
        <link href="https://fonts.googleapis.com/css?family=Raleway:100,600" rel="stylesheet" type="text/css">
        <link rel="icon" type="image/png" href="{{ URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations) }}" />
        <link rel="Shortcut icon" type="image/png" href="{{ URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations) }}" type="image/x-icon" />
        <link rel="apple-touch-icon" href="{{ URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations) }}">
        <meta name="msapplication-TileColor" content="#ff2658">
        <meta name="msapplication-TileImage" content="{{ URL::asset($get_app_configuration->path_icon_app_configurations.$get_app_configuration->name_icon_app_configurations) }}">
        <link href="{{ URL::asset('public/dashboard/plugins/bootstrap/css/bootstrap.min.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/dashboard/css/style.css') }}" rel="stylesheet">
        <link href="{{ URL::asset('public/dashboard/css/colors/blue.css') }}" id="theme" rel="stylesheet">
        <meta name="csrf-token" content="{{ csrf_token() }}">
        <style>
            .login-register.login-sidebar
            {
                background-image:url(public/images/background/login-register.jpg);
                background-repeat: no-repeat;
                background-attachment: fixed;
                background-position: center; 
            }
        </style>
    </head>
    <body>
        <div class="preloader">
            <svg class="circular" viewBox="25 25 50 50">
                <circle class="path" cx="50" cy="50" r="20" fill="none" stroke-width="2" stroke-miterlimit="10" />
            </svg>
        </div>

        <section id="wrapper" class="login-register login-sidebar">
            <div class="login-box card">
                <div class="card-body">
                    @yield('content')
                </div>
            </div>
        </section>

        <script src="{{ URL::asset('public/dashboard/plugins/jquery/jquery.min.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/plugins/bootstrap/js/popper.min.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/plugins/bootstrap/js/bootstrap.min.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/js/jquery.slimscroll.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/js/waves.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/js/sidebarmenu.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/plugins/sticky-kit-master/dist/sticky-kit.min.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/plugins/sparkline/jquery.sparkline.min.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/js/custom.min.js') }}"></script>
        <script src="{{ URL::asset('public/dashboard/plugins/styleswitcher/jQuery.style.switcher.js') }}"></script>
    </body>
</html>
