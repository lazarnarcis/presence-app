<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $name = $_POST['name'];

    $result = $api->forgotUser($name);
    echo json_encode($result);
?>