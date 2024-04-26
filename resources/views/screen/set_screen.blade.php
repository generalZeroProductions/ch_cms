@php

    if (session_status() == PHP_SESSION_NONE) {
        session_start();
    }
    $currentUrl = $_SERVER['REQUEST_URI'];
    $urlParts = explode('/', $currentUrl);
    $parameters = end($urlParts);
    $parameterParts = explode('_', $parameters);

    $windowWidth = $parameterParts[2];
    $_SESSION['screenwidth'] = $windowWidth;
    $_SESSION['mobile'] = false;
    if ($windowWidth < 800) {
        $_SESSION['mobile'] = true;
    }
    $newLocation = $parameterParts[0] . '_' . $parameterParts[1];

@endphp
<script>
    window.onload = function() {
        var newUrl = "/{{ $newLocation }}";
        window.location.href = newUrl;
    };
</script>


