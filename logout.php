<?php
    session_start();
    require("./goAPI/config.php");
    $db = new Database();
    require("./php/APIHandler.php");
    $api = new APIHandler();

    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $data = array(
        "user" => $session_user_info['username'],
        "type" => "LOGOUT",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => $_SERVER['REMOTE_ADDR'],
        "text" => "Just logged out!"
    );
    $db->insert("activity", $data);
    $_SESSION = array();
    session_destroy();
    header("location: index.php");
    exit();
?>