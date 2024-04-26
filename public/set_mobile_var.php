<?php

function setMobile($route)
{
    echo '<script>
    if (window.innerWidth !== ' . $_SESSION['screenwidth'] . ') {
        window.location.href = "/screen/get/' . $route . '_" + window.scrollY;
    }
    else{
        console.log("no way");
    }
</script>';
}
