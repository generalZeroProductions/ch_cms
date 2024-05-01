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
    <script src="{{ asset('scripts/tabsCtl.js') }}"></script>
    <script src="{{ asset('scripts/editors.js') }}"></script>
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

        $editMode = false;
        $allRoutes = null;
        $buildMode = false;
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

        $route = 'none';
        $page; //   for every user
        if (isset($newLocation)) {
            $page = ContentItem::where('title', $newLocation)
                   ->where('type', 'page')
                   ->first();

        } else {
            $firstNav = Navigation::where('type', 'nav')->orderBy('index')->first();
            if ($firstNav) {
                $page = ContentItem::where('title', $firstNav->route)->first();
            } else {
                $route = '/no_pages';
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
                }
            }
        }

    @endphp


    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    @include('app.navigation', ['route' => $route, 'location' => $location])
    <div id = "main_content">
        @if ($route === 'no_pages')
            @include('app.no_pages_found')
        @endif
    </div>



    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
</body>
<script>
    window.onload = function() {
        console.log("route is: " + '{{ $route }}');
        scriptAsset = "{{ asset('scripts/') }}/"
        if ('{{ $route }}' != 'no_pages') {
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

            loadPage("{{ $route }}");
            window.scrollTo(0, "{{ $scrollTo }}");
            @if (Auth::check())
                iconsAsset = "{{ asset('icons/') }}/";
                imagesAsset = "{{ asset('images/') }}/";
                allRoutes = decodeRoutes('{{ $allRoutes }}');
            @endif
           
        }
    };
</script>




</html>
{{--    
  

window.addEventListener('popstate', function(event) {
            closeModal();
        });
                allImages = '{{ $allImages }}'; --}}
