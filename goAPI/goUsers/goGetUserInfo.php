<?php
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];

    $db->where("id", $user_id);
    $result = $db->select("users");

    $err_message = 1;
    if (is_array($result) && count($result)){ 
        $err_message = $result[0];
    }

    echo json_encode($err_message);
?>