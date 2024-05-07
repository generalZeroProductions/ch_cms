@include('/app.page_display')
@include('app.all_scripts')
@include('app.init')
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name') }}</title>

    <!-- Fonts -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">



</head>

<body class="antialiased">
    @php
        $currentUrl = $_SERVER['REQUEST_URI'];
        $urlParts = explode('/', $currentUrl);
       
        $location;
     
        $page = getPage($urlParts[1]);
           
        if (isset($page)) {
            Session::put('location', $page->title);
            $route = $page->title;
            $location = [
                'page' => $page,
                'row' => null,
                'item' => null,
                'scroll' => null,
            ];
        }
        $editMode = getEditMode();
        $buildMode = getBuildMode();
        $mobile = getMobile();
        $scrollTo = getScroll();
        $contents = View::make('app.page_layout', ['location' => $location, 'tabContent' => false])->render();
        $allRoutes = setAllRoutes();

    @endphp
    @include('app.navigation')




    {!! $contents !!}


    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
@include('forms.main_modal')
</body>
<script>
    window.onload = function() {
        iconsAsset = "{{ asset('icons/') }}/";
        imagesAsset = "{{ asset('images/') }}/";
        fontsAsset = "{{ asset('fonts/') }}/";
        allRoutes = decodeRoutes('{{ $allRoutes }}');
        console.log('{{ $scrollTo }}');
        window.scrollTo(0,190);
    }
</script>

</html>
