<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <title>@yield('title', 'Auth') | Portfolio Admin</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <link rel="shortcut icon" href="{{ asset('assets/images/favicon.ico') }}">
    <script src="{{ asset('assets/js/config.js') }}"></script>
    <link href="{{ asset('assets/css/vendor.min.css') }}" rel="stylesheet">
    <link href="{{ asset('assets/css/app.min.css') }}" rel="stylesheet" id="app-style">
    <link href="{{ asset('assets/css/icons.min.css') }}" rel="stylesheet">
</head>

<body class="authentication-bg">

<div class="account-pages pt-sm-5">
    <div class="container">
        <div class="row justify-content-center">
            <div class="col-xxl-4 col-lg-5">

                {{-- Logo --}}
                <div class="text-center mb-4">
                    <a href="/">
                            <span class="logo-light">
                                <img src="{{ asset('assets/images/logo.png') }}" alt="logo" height="24">
                            </span>
                        <span class="logo-dark">
                                <img src="{{ asset('assets/images/logo-dark.png') }}" alt="logo" height="24">
                            </span>
                    </a>
                </div>

                {{ $slot }}

            </div>
        </div>
    </div>
</div>

<script src="{{ asset('assets/js/vendor.min.js') }}"></script>
<script src="{{ asset('assets/js/app.js') }}"></script>
</body>
</html>
