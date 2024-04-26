<?php

if (session_status() == PHP_SESSION_NONE) {
    session_start();
}
if(isset($_POST['action']) && $_POST['action'] === 'startSession') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} 
elseif (isset($_POST['action']) && $_POST['action'] === 'updateRoute') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} 
elseif (isset($_POST['action']) && $_POST['action'] === 'refreshScreen') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} 
elseif (isset($_POST['action']) && $_POST['action'] === 'editToggle') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => "Invalid request"));
}

function replaceSessionVars()
{
    $_SESSION['mobile'] = false;
    if (isset($_POST['width'])) {
        $_SESSION['screenwidth'] = $_POST['width'];
        if ($_POST['width'] < 800) {
            $_SESSION['mobile'] = true;
        }
    }
    if(isset($_POST['routeId'])) {
        $_SESSION['routeId'] = $_POST['routeId'];
    }
    if(isset($_POST['scrollTo'])) {
        $_SESSION['scrollTo'] = $_POST['scrollTo'];
    }
    if(isset($_POST['edit'])) {
        $_SESSION['edit'] = false;
        if( $_POST['edit']==='true')
        {
            $_SESSION['edit'] =true;
        }
       
    }
}
