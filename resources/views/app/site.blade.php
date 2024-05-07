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
    <script src="{{ asset('scripts/nav_edit.js') }}"></script>
    <script src="{{ asset('scripts/dropdown_edit.js') }}"></script>
    <script src="{{ asset('scripts/articles.js') }}"></script>
    <script src="{{ asset('scripts/tabs_display.js') }}"></script>
    <script src="{{ asset('scripts/tabs_edit.js') }}"></script>
    <script src="{{ asset('scripts/slideshow_edit.js') }}"></script>
    <script src="{{ asset('scripts/dashboard.js') }}"></script>
    <script src="{{ asset('scripts/images.js') }}"></script>
    <script src="{{ asset('scripts/tooltips.js') }}"></script>
    <script src="{{ asset('tinymce/tinymce.min.js') }}"></script>


</head>

<body class="antialiased">
    @php
        use Illuminate\Support\Facades\Session;
        use App\Models\Navigation;
        use App\Models\ContentItem;
        use Illuminate\Support\Facades\Storage;

        $newSession = true;
        $screenWidth = 1920;
        $mobile = false;
        $scrollTo = 0;
        $location = null;
        $editMode = false;
        $allRoutes = null;
        $buildMode = false;
        $returnPage;
        if (Session::has('screenwidth')) {
            $newSession = false;
            $screenWidth = Session::get('screenwidth');
        }
        if (Session::has('mobile')) {
            Session::put('mobile', Session::get('mobile'));
        }
        if (Session::has('scrollTo')) {
            $scrollTo = (int) Session::get('scrollTo');
        }

        $route;
        $page;

        $routeSetBy = '';

        if (isset($newLocation)) {
            $page = ContentItem::where('type', 'page')->where('title', $newLocation)->first();
            $routeSetBy = 'newLocation @ ' . $newLocation;
        } elseif (Session::has('location')) {
            $page = ContentItem::where('type', 'page')->where('title', Session::get('location'))->first();
            $route = Session::get('location');
        } else {
            $firstNav = Navigation::where('type', 'nav')->orderBy('index')->first();
            if ($firstNav) {
                $page = ContentItem::where('title', $firstNav->route)->first();
                $routeSetBy = 'first Nav ';
            }
        }
        if (isset($page)) {
            $route = $page->title;
            $location = [
                'page' => $page,
                'row' => null,
                'item' => null,
                'scroll' => null,
            ];
        } else {
            $route = 'no_pages';
        }

        if (Auth::check()) {
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

            if (Session::get('buildMode')) {
                $buildMode = Session::get('buildMode');
                if (Session::has('returnPage')) {
                    $page = ContentItem::where('type', 'page')->where('title', Session::get('returnPage'))->first();
                    if ($page) {
                        $newLocation = Session::get('returnPage');
                        Session::put('returnPage', '');
                    }
                }
            }
        }
    @endphp


    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    @include('app.navigation', ['route' => $route, 'location' => $location])
    <div class= "container-fluid full-page" id = "main_content">
        @if ($route === 'no_pages')
            @include('app.no_pages_found')
        @endif
    </div>
    <div class="slider-container">
        <div class="slider" id="slider">
            <div class="slider-handle" id="handle"></div>
        </div>
    </div>


    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
</body>

<script>
    window.onload = function() {
        currentScreen = window.innerWidth;
        console.log("route is: " + '{{ $route }}' + ' set by ' + '{{ $routeSetBy }}');
        scriptAsset = "{{ asset('scripts/') }}/"
        if ('{{ $route }}' != 'no_pages') {
            if ('{{ $newSession }}') {
                window.location.href = "/session/screen?" + window.window.innerWidth + "?" + "{{ $route }}";
            }
            if (window.innerWidth != '{{ $screenWidth }}') {
                window.location.href = "/session/screen?" + window.window.innerWidth + "?" + "{{ $route }}";
            }

            windowVisible();
            window.addEventListener('resize', function() {
                handleResize("{{ $route }}");
            });
            loadPage("{{ $route }}");
            console.log("{{ $scrollTo }}");
            window.scrollTo(0, "{{ $scrollTo }}");
            @if (Auth::check())
                iconsAsset = "{{ asset('icons/') }}/";
                imagesAsset = "{{ asset('images/') }}/";
                fontsAsset = "{{ asset('fonts/') }}/";
                allRoutes = decodeRoutes('{{ $allRoutes }}');
            @endif

        }
    }
</script>

<style>
    .full-page {
        padding: 0px;
        margin: 0px;
    }
</style>


</html>
{{--       window.addEventListener('resize', function() {
                handleResize("{{ $route }}");
            });
  

window.addEventListener('popstate', function(event) {
            closeModal();
        });
                allImages = '{{ $allImages }}'; --}}
<style>
    .slider-container {
        position: relative;
        height: 300px;
    }

    .slider {
        position: absolute;
        top: 0;
        left: 50%;
        transform: translateX(-50%);
        height: 100%;
        width: 20px;
        background-color: #ccc;
        cursor: pointer;
    }

    .slider-handle {
        position: absolute;
        top: 50%;
        left: 0;
        transform: translateY(-50%);
        width: 100%;
        height: 20px;
        background-color: #007bff;
        cursor: pointer;
    }
</style>
