<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $name = $_POST['name'];
    $password = $_POST['password'];

    $result = $api->loginUser($name, $password);

    $err_message = 1;
    if (is_array($result) && count($result)) {
        $_SESSION['logged'] = true;
        $_SESSION['user_id'] = $result[0]['id'];
    } else {
        $err_message = $result;
    }

    echo json_encode($err_message);
?>