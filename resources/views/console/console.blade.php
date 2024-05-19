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
    <link rel="stylesheet" href="{{ asset('scripts/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('scripts/site.css') }}">
    <script src="{{ asset('scripts/app.js') }}"></script>
    <script src="{{ asset('scripts/articles.js') }}"></script>
    <script src="{{ asset('scripts/dashboard.js') }}"></script>
    <script src="{{ asset('scripts/tooltips.js') }}"></script>

</head>

<body class="antialiased">
    @php
        use App\Models\Navigation;
        use App\Models\ContentItem;
         use Illuminate\Support\Facades\Session;
       @endphp
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>

@yield('content')

    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
</body>


</html>


