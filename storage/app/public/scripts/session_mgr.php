<?php
use Illuminate\Support\Facades\Session;

if (isset($_POST['action']) && $_POST['action'] === 'startSession') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} elseif (isset($_POST['action']) && $_POST['action'] === 'updateRoute') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} elseif (isset($_POST['action']) && $_POST['action'] === 'refreshScreen') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} elseif (isset($_POST['action']) && $_POST['action'] === 'editToggle') {
    replaceSessionVars();
    echo json_encode(array("success" => true));
} else {
    echo json_encode(array("success" => false, "error" => "Invalid request"));
}

function replaceSessionVars()
{
    Session::put('mobile', false);
    if (isset($_POST['width'])) {
        Session::put('screenwidth', $_POST['width']);
        if ($_POST['width'] < 800) {
            Session::put('mobile', true);
        }
    }
    if (isset($_POST['scrollTo'])) {
        Session::put('scrollTo', $_POST['scrollTo']);
    }
    if (isset($_POST['edit'])) {
        Session::put('edit', false);
        if ($_POST['edit'] === 'true') {
            Session::put('edit', true);
        }
    }
}
