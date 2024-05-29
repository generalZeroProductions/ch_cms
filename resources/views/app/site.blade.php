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
        $route=null;
        $pageId = null;
        $currentUrl = urldecode($_SERVER['REQUEST_URI']);
        $urlParts = explode('/', $currentUrl);
        $page = ContentItem::where('type', 'page')
            ->where('title', $urlParts[1])
            ->first();
        if ($page) {
            $pageId = $page->id;
            $route = $page->title;
        }
        else{
            if($urlParts[1]==="联系我们")
            {
               $pageId = '联系我们';
               $route ='联系我们';
            }
        }

        $scrollTo = Session::get('scrollTo');
       
       // Session::forget('scrollTo');
        $allRoutes = setAllRoutes();

    @endphp

    <div class="nav-fixed-top" id="main-navigation"></div>
    <div id="headspace"></div>
    @php
        //echo $scrollTo. ' how its set before nav';
    @endphp
    <div id="page_content"></div>
     <br>
      <br>
    <div id="site_footer"></div>
   
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

        renderAll('{{ $route }}','{{ $pageId }}', '{{ $scrollTo }}');
       // renderNavigation('{{ $route }}');
       
       // renderPageContent('{{ $pageId }}', '{{ $scrollTo }}');
       //  renderFooter();
        currentScreen = window.innerWidth;
        window.addEventListener('resize', function() {
            handleResize("{{ $route }}");
        });

    }
</script>

</html>
