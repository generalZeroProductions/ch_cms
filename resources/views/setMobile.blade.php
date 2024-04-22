<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>Laravel</title>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>凤凰纵横</title>
    <script src="{{ asset('scripts/site.js') }}"></script>
</head>

<body class="antialiased">
    <script>
        window.onload = function() {
            setSessionScreenSize();
            window.location.href = "/";
        };
    </script>
</body>

</html>
