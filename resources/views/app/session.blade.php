@php
    use Illuminate\Support\Facades\Session;

    $currentUrl = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $currentUrl);
    $parameters = end($urlParts);
    $parameterParts = explode('?', $parameters);
    $returnLocation;
    if ($parameterParts[0] === 'screen') {
        Session::put('screenwidth', $parameterParts[1]);
        Session::put('mobile', false);
        if ($parameterParts[1] < 800) {
            Session::put('mobile', true);
        }
        $returnLocation = '/' . $parameterParts[2];
    }

    if ($parameterParts[0] === 'edit') {
        Session::put('edit', false);
        if ($parameterParts[1] === 'on') {
            Session::put('edit', true);
            $returnLocation = '/';
        } else {
            $returnLocation = '/dashboard';
        }
    }
    if ($parameterParts[0] === 'build') {
        Session::put('builder', false);
        if ($parameterParts[1] === 'on') {
            Session::put('builder', true);
        }
    }
    
    if (isset($parameterParts[3])) {
        Session::put('scrollTo', $parameterParts[3]);
    }

@endphp
<script>
    window.onload = function() {
        window.location.href = "{{ $returnLocation }}";
    };
</script>
