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

</head>

<body class="antialiased">
    @php
        use App\Models\Navigation;
        use App\Models\ContentItem;
        $editMode = true;
        $route;
        if (isset($pageId)) {
            $page = ContentItem::findOrFail($pageId);
            $route = $page->title;
            dd("herre");
        }
        // Check if $currentPage is set
        else {
            // Fetch items from the navigation table where the type is 'nav' and select the one with the lowest index
            $lowestIndexItem = Navigation::where('type', 'nav')->orderBy('index')->first();
            if ($lowestIndexItem) {
                $route = $lowestIndexItem->route;
            } else {
                // If no item was found, set $currentPage to a default value ('products' in this case)
                $route = 'page 3';
            }
        }
    @endphp
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>

    @include('navigation')
    <div id = "main_content" class = "container">
    </div>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    <script>
        window.onload = function() {
            linkImagePath = "{{ asset('icons/link.svg') }}";
            var route = "{{ $route }}";
            loadPage(route);
        };
    </script>
</body>

</html>
