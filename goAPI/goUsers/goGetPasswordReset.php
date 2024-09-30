<?php
    session_start();
    require("../config.php");
    require("../goFunctions.php");
    $db = new Database();

    $uniqueid = $_REQUEST['uniqueid'];

    $query = "select * from forgot_password where uniqueid='$uniqueid'";
    $forgot_password = $db->query($query);

    $err_message = 1;
    if (is_array($forgot_password) && count($forgot_password) > 0) {
        $err_message = 1;
    } else {
        $err_message = "Doesn't exist request password for this uniqueid: $uniqueid";
    }

    echo json_encode($err_message);
?>