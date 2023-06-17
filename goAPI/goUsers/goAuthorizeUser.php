<?php
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];

    $data = array(
        "account_confirm" => 1
    );
    $db->where("id", $user_id);
    $result1 = $db->update("users", $data);

    $session_user_id = $_REQUEST['session_user_id'];

    $db->where('id', $user_id);
    $result = $db->select("users", ['username']);
    $username = $result[0]['username'];

    $db->where('id', $session_user_id);
    $result = $db->select("users", ['username']);
    $session_username = $result[0]['username'];

    $data = array(
        "user" => $session_username,
        "type" => "AUTHORIZE",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => $_SERVER['REMOTE_ADDR'],
        "text" => "You authorized $username!"
    );
    $db->insert("activity", $data);

    $data = array(
        "user" => $username,
        "type" => "AUTHORIZE",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => "Invalid",
        "text" => "$session_username authorized you!"
    );
    $db->insert("activity", $data);

    echo json_encode($result1);
?>