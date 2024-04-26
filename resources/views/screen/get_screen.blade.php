@php
 $parameterParts = explode('_', $route);
$settings = 'init_'.$parameterParts[1];
@endphp
<script>
    window.onload = function() {
        var newUrl = "/screen/set/{{ $settings}}_" + window.innerWidth;
        window.location.href = newUrl;
    };
</script>
