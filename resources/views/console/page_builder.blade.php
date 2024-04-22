<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>Laravel</title>

    <!-- Fonts -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>凤凰纵横</title>
    <link rel="stylesheet" href="{{ asset('scripts/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('scripts/site.css') }}">
    <script src="{{ asset('scripts/site.js') }}"></script>
    <script src="{{ asset('scripts/navCtl.js') }}"></script>
    <script src="{{ asset('scripts/tabsCtl.js') }}"></script>

</head>

<body class="antialiased">

<div class = "container">
<button class = "btn btn-primary" onClick = "openBaseModal('createRow', null, null, null)">创建行</button>
</div>

<script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
<script src="{{ asset('scripts/popper.min.js') }}"></script>
<script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
   
</body>