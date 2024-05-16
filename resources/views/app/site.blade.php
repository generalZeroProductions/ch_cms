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
    @include('app.all_scripts')
    @include('app.init')
    @php
        use Illuminate\Support\Facades\Session;
        use App\Models\Navigation;
        use App\Models\ContentItem;
        $currentUrl = $_SERVER['REQUEST_URI'];

        $urlParts = explode('/', $currentUrl);
        $page = ContentItem::where('type', 'page')
            ->where('title', $urlParts[1])
            ->first();
        $navIndex = 0;
        if (isset($currentKey)) {
            $navIndex = $currentKey;
        }
        $scrollTo = Session::get('scrollTo');
        Log::info('scroll to : ' . Session::get('scrollTo'));
        Session::forget('scrollTo');
        $allRoutes = setAllRoutes();
    @endphp

    <div class="nav-fixed-top" id="main-navigation"></div>
    <div id="headspace" style= "height:200"></div>

    <div id="page_content"></div>
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
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
        renderNavigation('{{ $page->title }}', '{{ $navIndex }}')
        renderPageContent('{{ $page->id }}', '{{ $scrollTo }}');
        currentScreen = window.innerWidth;
        window.addEventListener('resize', function() {
            handleResize("{{ $page->title }}");
        });

    }
</script>

</html>
