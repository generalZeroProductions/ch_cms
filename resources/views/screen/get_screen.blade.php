
<script>
    window.onload = function() {
        var newUrl = "/screen/set/{{ $route}}_" + window.innerWidth;
        window.location.href = newUrl;
    };
</script>
