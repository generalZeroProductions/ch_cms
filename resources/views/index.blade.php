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

</head>

<body class="antialiased">
    @php
    use App\Models\Navigation;
    use \App\Models\ContentItem;
        $editMode = true;

        // Check if $currentPage is set
        if (!isset($currentPage)) {
            // Fetch items from the navigation table where the type is 'nav' and select the one with the lowest index
            $lowestIndexItem = Navigation::where('type', 'nav')->orderBy('index')->first();

            // Check if an item was found
            if ($lowestIndexItem) {
                // Set $currentPage to the value of the lowest index item
                $currentPage = $lowestIndexItem->index;
            } else {
                // If no item was found, set $currentPage to a default value ('products' in this case)
                $currentPage = 'products';
            }
        }
    @endphp
    





    {{-- <script src="https://code.jquery.com/jquery-3.2.1.slim.min.js"
        integrity="sha384-KJ3o2DKtIkvYIK3UENzmM7KCkRr/rE9/Qpg6aAZGJwFDMVNA/GpGFF93hXpG5KkN" crossorigin="anonymous">
    </script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/popper.js@1.12.9/dist/umd/popper.min.js" integrity="sha384-ApNbgh9B+Y1QKtv3Rn7W3mgPxhU9K/ScQsAP7hUibX39j7fakFPskvXusvfa0b4Q" crossorigin="anonymous"></script> --}}
    {{-- <script src="https://cdn.jsdelivr.net/npm/bootstrap@4.0.0/dist/js/bootstrap.min.js" integrity="sha384-JZR6Spejh4U02d8jOt6vLEHfe/JQGiRRSQQxSfFWpi1MquVdAyjUar5+76PVCmYl" crossorigin="anonymous"></script>  --}}
    <script src="{{ asset('scripts/jquery-3.2.1.slim.min.js') }}"></script>
    <script src="{{ asset('scripts/bootstrap.min.js') }}"></script>
    <script src="{{ asset('scripts/popper.min.js') }}"></script>
    @include('navigation')
    <script>
        window.onload = function() {
            linkImagePath = "{{ asset('icons/link.svg') }}";
        };
    </script>
</body>

</html>
