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
        use Illuminate\Support\Facades\Session;
        Session::put('buildMode', true);
        $route = 'none';
        $page; //   for every user
        if (isset($newLocation)) {
            $page = ContentItem::where('title', $newLocation)->first();
        }
        $route = $page->title;
        $location = [
            'page' => $page,
            'row' => null,
            'item' => null,
            'scroll' => null,
        ];
        $mobile = false;
      
        if (isset($_SESSION['screenwidth'])) {
            $newSession = false;
        }
        if (isset($_SESSION['mobile'])) {
            $mobile = $_SESSION['mobile'];
        }
        $editMode = false;
        $scrollTo = 0;
        $allRoutes = null;
        if (Auth::check()) {
            if (isset($_SESSION['edit'])) {
                $editMode = $_SESSION['edit'];
                if ($editMode) {
                    $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
                    $allRoutes = json_encode($getRoutes);
                }
            }
            if (isset($_SESSION['scrollTo'])) {
                $scrollTo = $_SESSION['scrollTo'];
            }
        }
      
    @endphp
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    @if (Auth::check())
    @endif
    <div id = "main_content">
    </div>
    <button>Confirm</button>
    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
</body>
<script>
    window.onload = function() {
        scriptAsset = "{{ asset('scripts/') }}/"
        if ('{{ $newSession }}') {
            initializeSession("{{ $route }}");
        }
        window.addEventListener('resize', function() {
            handleResize("{{ $route }}");
        });
        windowVisible();
        if ('{{ $editMode }}') {
            iconsAsset = "{{ asset('icons/') }}/";
            imagesAsset = "{{ asset('images/') }}/";
            allRoutes = decodeRoutes('{{ $allRoutes }}');
        }
        loadPage("{{ $route }}");
        window.scrollTo(0, '{{ $scrollTo }}');
    };
</script>

</html>
