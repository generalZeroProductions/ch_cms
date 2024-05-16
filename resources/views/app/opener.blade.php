@php
    use Illuminate\Support\Facades\Session;
    use App\Models\Navigation;
    $route;
    $firstNav = Navigation::where('type', 'nav')->orderBy('index')->first();
    if ($firstNav) {
        $route = $firstNav->route;
    }
    Session::put('scrollTo',0);
@endphp

<script>
    window.onload = function() {
        window.location.href = "/session/screen?" + window.window.innerWidth + "?" + "{{ $route }}";
    }
</script>
