<?php


if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

if (isset($_POST['editToggle'])) {
    var_dump($_POST['editToggle']);
    replaceSessionVars();
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => "Invalid request"));
}

function replaceSessionVars()
{
    $_SESSION['edit'] = false;
    if($_POST['editToggle']==='true')
    {
        $_SESSION['edit'] = true;
    }
}