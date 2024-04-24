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
    <script src="{{ asset('scripts/main.js') }}"></script>
    <script src="{{ asset('scripts/navCtl.js') }}"></script>
    <script src="{{ asset('scripts/articlesCtl.js') }}"></script>
    <script src="{{ asset('scripts/tabsCtl.js') }}"></script>
    <script src="{{ asset('scripts/editors.js') }}"></script>

</head>

<body class="antialiased">
    @php
        use App\Models\Navigation;
        use App\Models\ContentItem;
        include 'set_mobile.php';
        session_start();
        $_SESSION['edit'] = true;
        $_SESSION['clicks'] = 0;
        $_SESSION['clicks'] += 1;
        $sesh =  json_encode(session()->all());
        
        $mobile = $mobileVariable = setMobile();

        $editMode = true;
        $route;
        $location;
        if (isset($newLocation)) {
            $page = ContentItem::findOrFail($newLocation);
            $location = [
                    'page' => $page,
                    'row' => null,
                    'item' => null,
                ];
        } else {
           
            // Fetch items from the navigation table where the type is 'nav' and select the one with the lowest index
            $firstNav = Navigation::where('type', 'nav')->orderBy('index')->first();
            $page = ContentItem::where('title', $firstNav->route)->first();
            if ($firstNav) {
                $location = [
                    'page' => $page,
                    'row' => null,
                    'item' => null,
                ];
            } else {
                // If no item was found, set $currentPage to a default value ('products' in this case)
                $page = 'page 3';
            }
        }
        $route = $location['page']->title;
        
        $getRoutes = ContentItem::where('type', 'page')->pluck('title')->toArray();
        $allRoutes = json_encode($getRoutes);
    @endphp
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>

    @include('navigation', ['location' => $location])
    <div id = "main_content">
    </div>

    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>

    <script>
        window.onload = function() {
            iconsAsset = "{{ asset('icons/') }}/";
            imagesAsset = "{{ asset('images/') }}/";
            allRoutes = decodeRoutes('{{ $allRoutes }}')
            loadPage("{{ $location['page']->title }}");
        };
    </script>
</body>

</html>
