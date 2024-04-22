<?php
session_start();
$_SESSION['mobile'] =  false;
if (isset($_POST['width'])) {
    $_SESSION['screenWidth'] = $_POST['width'];
    if( $_POST['width']<800)
    {
        $_SESSION['mobile'] = true;
    }
}
