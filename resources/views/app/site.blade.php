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
    <script src="{{ asset('scripts/main.js') }}"></script>
    <script src="{{ asset('scripts/navigation.js') }}"></script>
    <script src="{{ asset('scripts/articles.js') }}"></script>
    <script src="{{ asset('scripts/tabsCtl.js') }}"></script>
    <script src="{{ asset('scripts/editors.js') }}"></script>
    <script src="{{ asset('scripts/dashboard.js') }}"></script>
    <script src="{{ asset('scripts/session_calls.js') }}"></script>
    <script src="{{ asset('scripts/images.js') }}"></script>
    <script src="{{ asset('scripts/tooltips.js') }}"></script>

</head>

<body class="antialiased">
    @php
        use Illuminate\Support\Facades\Session;
        use App\Models\Navigation;
        use App\Models\ContentItem;

        use Illuminate\Support\Facades\Storage;

        $route = 'none';
        $page; //   for every user
        if (isset($newLocation)) {
            $page = ContentItem::where('title', $newLocation)->first();
        } else {
            $firstNav = Navigation::where('type', 'nav')->orderBy('index')->first();
            if ($firstNav) {
                $page = ContentItem::where('title', $firstNav->route)->first();
            }
        }

        $route = $page->title;
        $location = [
            'page' => $page,
            'row' => null,
            'item' => null,
            'scroll' => null,
        ];
        $mobile = false;
        $newSession = true;
        $screenWidth = 1920;
        if (Session::has('screenwidth')) {
            $newSession = false;
            $screenWidth = Session::get('screenwidth');
        }
        if (Session::has('mobile')) {
            Session::put('mobile', Session::get('mobile'));
        }
        $editMode = false;
        $scrollTo = 0;
        $allRoutes = null;
        $buildMode = false;
        $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
        $allRoutes = json_encode($getRoutes);
        $directory = 'public/images';
        $files = Storage::allFiles($directory);
        $allImages = [];
        foreach ($files as $file) {
            if ($file !== '.' && $file !== '..') {
                $allImages[] = pathinfo($file, PATHINFO_BASENAME);
            }
        }
        if (Session::has('edit')) {
            $editMode = Session::get('edit');
        }
        if (Session::has('scrollTo')) {
            $scrollTo = (int) Session::get('scrollTo');
        }
        if (Session::get('buildMode')) {
            $buildMode = Session::get('buildMode');
        }

    @endphp
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    <h5>"scroll= {{ Session::get('scrollTo') }}</h5>
    <h5>"Edit = {{ Session::get('edit') }}</h5>
    <h5>"build= {{ Session::get('buildMode') }}</h5>
    @if (Auth::check())
    @endif
    @if (!$buildMode)
        @include('app.navigation')
    @endif
    <div id = "main_content">
    </div>



    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
</body>
<script>
    window.onload = function() {
        scriptAsset = "{{ asset('scripts/') }}/"
        if ('{{ $newSession }}') {
            window.location.href = "/session/screen?" + window.window.innerWidth + "?" + "{{ $route }}";
        }
        if (window.innerWidth != '{{ $screenWidth }}') {
            window.location.href = "/session/screen?" + window.window.innerWidth + "?" + "{{ $route }}";
        }
        window.addEventListener('resize', function() {
            handleResize("{{ $route }}");
        });
        windowVisible();
        iconsAsset = "{{ asset('icons/') }}/";
        imagesAsset = "{{ asset('images/') }}/";
        allRoutes = decodeRoutes('{{ $allRoutes }}');

        loadPage("{{ $route }}", '{{ $scrollTo }}');
        console.log("PAGE LOAD");
    };
</script>

</html>
{{--         allImages = '{{ $allImages }}'; --}}
