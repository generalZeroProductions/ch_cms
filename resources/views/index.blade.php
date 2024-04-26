<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>{{config('app.name')}}</title>

    <!-- Fonts -->
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>凤凰纵横</title>
    <link rel="stylesheet" href="{{ asset('scripts/bootstrap.min.css') }}">
    <link rel="stylesheet" href="{{ asset('scripts/site.css') }}">
    <script src="{{ asset('scripts/main.js') }}"></script>
    <script src="{{ asset('scripts/navCtl.js') }}"></script>
    <script src="{{ asset('scripts/articlesCtl.js') }}"></script>
    <script src="{{ asset('scripts/tabsCtl.js') }}"></script>
    <script src="{{ asset('scripts/editors.js') }}"></script>
    <script src="{{ asset('scripts/dashboard.js') }}"></script>

</head>

<body class="antialiased">
    @php
        use App\Models\Navigation;
        use App\Models\ContentItem;
        $route = 'none';
        $routeId;
        $newSession = true;
        $scrollTo = 0;
        $mobile = false;
        $editMode = false;
        $location = [
            'page' => null,
            'row' => null,
            'item' => null,
            'scroll' => null,
        ];
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        } else {
            if (isset($_SESSION['screenwidth'])) {
                $newSession = false;
            }
            if (isset($_SESSION['edit'])) {
                $editMode = $_SESSION['edit'];
            }
        }
        if (isset($newLocation)) {
            $location_params = explode('_', $newLocation);
            if ($location_params[0] === 'init') {
            } else {
                $page = ContentItem::findOrFail($location_params[0]);
                $scrollTo = $location_params[1];
                $route = $page->title;
                $routeId = $page->id;
                $location['page'] = $page;
            }
        }
        if ($route === 'none') {
            $firstNav = Navigation::where('type', 'nav')->orderBy('index')->first();

            if ($firstNav) {
                $page = ContentItem::where('title', $firstNav->route)->first();
                $location = [
                    'page' => $page,
                    'row' => null,
                    'item' => null,
                ];
                $route = $page->title;
                $routeId = $page->id;
            }
        }
        if (isset($_SESSION['mobile'])) {
            $mobile = $_SESSION['mobile'];
        }
        $route = $location['page']->title;

        $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
        $allRoutes = json_encode($getRoutes);
    @endphp
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    @include('navigation')
    <div id = "main_content">
    </div>

    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
</body>
<script>
    window.onload = function() {
        if ('{{ $newSession }}') {
            window.location.href = "/screen/get/{{ $route }}_" + window.scrollY;
        }
        iconsAsset = "{{ asset('icons/') }}/";
        imagesAsset = "{{ asset('images/') }}/";
        scriptAsset = "{{ asset('scripts/') }}/";
        currentRoute = '{{ $routeId }}';
        allRoutes = decodeRoutes('{{ $allRoutes }}')
        window.addEventListener('resize', handleResize);
        loadPage("{{ $location['page']->title }}");
        window.scrollTo(0, '{{ $scrollTo }}');
    };
</script>

</html>
