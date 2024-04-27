@php
if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }
 $location_params = explode('_', $newLocation);
 $location = $location_params[0];
 $_SESSION['scrollTo'] =  $location_params[1];
@endphp

<script>
 window.onload = function() {
    window.location.href = "/"+location;
 }
</script>