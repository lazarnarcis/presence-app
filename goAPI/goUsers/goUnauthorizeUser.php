<?php
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];

    $data = array(
        "account_confirm" => 0
    );
    $db->where("id", $user_id);
    $result1 = $db->update("users", $data);

    $session_user_id = $_REQUEST['session_user_id'];

    $db->where('id', $user_id);
    $result = $db->getOne("users", ['username']);
    $username = $result['username'];

    $db->where('id', $session_user_id);
    $result = $db->getOne("users", ['username']);
    $session_username = $result['username'];

    $data = array(
        "user" => $session_username,
        "type" => "UNAUTHORIZE",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => $_SERVER['REMOTE_ADDR'],
        "text" => "You unauthorized $username!"
    );
    $db->insert("activity", $data);

    $data = array(
        "user" => $username,
        "type" => "UNAUTHORIZE",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => "Unknown",
        "text" => "$session_username unauthorized you!"
    );
    $db->insert("activity", $data);

    echo json_encode($result1);
?>