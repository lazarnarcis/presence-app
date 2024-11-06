<?php
    require("../config.php");
    $db = new Database();

    $result = $db->select("discord_roles");

    $err_message = [];
    if (is_array($result) && count($result)){ 
        $err_message = $result;
    }

    echo json_encode($err_message);
?>