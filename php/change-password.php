<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $uniqueid = $_POST['uniqueid'];
    $password = $_POST['password'];

    $result = $api->changePasswordUser($uniqueid, $password);
    echo json_encode($result);
?>