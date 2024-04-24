<?php

function setMobile() {
    if (isset($_SESSION['mobile'])) {
        if (isset($_SESSION['screenWidth'])) {
            echo '<script>
                if (window.innerWidth !== ' . $_SESSION['screenWidth'] . ') {
                    window.location.href = "/set_mobile";
                }
            </script>';
            $mobile = $_SESSION['mobile'];
            return $mobile; // Return the variable if needed
        }
    } else {
        echo '<script>
            window.location.href = "/set_mobile";
        </script>';
    }
}

