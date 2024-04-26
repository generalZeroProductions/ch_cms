<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>凤凰纵横</title>
    <link rel="stylesheet" href="{{ asset('scripts/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('scripts/site.css') }}">
    <link rel="stylesheet" href="{{ asset('scripts/grids.css') }}">
    <script src="{{ asset('scripts/main.js') }}"></script>
    <script src="{{ asset('scripts/navCtl.js') }}"></script>
    <script src="{{ asset('scripts/tabsCtl.js') }}"></script>
    <script src="{{ asset('scripts/editors.js') }}"></script>
    <script src="{{ asset('scripts/dashboard.js') }}"></script>

</head>

<body class="antialiased">

    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    <div id = "main_content">
        @yield('content')
    </div>

    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>

</body>
<script>
    window.onload = function() {
        scriptAsset = "{{ asset('scripts/') }}/";
        paginatePages();
    }
</script>

</html>
