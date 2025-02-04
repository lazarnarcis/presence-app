<?php
    require("../config.php");
    require("../goFunctions.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];

    $db->where('id', $user_id);
    $result1 = $db->getOne("users");
    $username = $result1['username'];

    $db->where("id", $user_id);
    $db->deleteRow("users");

    $session_user_id = $_REQUEST['session_user_id'];

    $db->where('id', $session_user_id);
    $result = $db->getOne("users", ['username']);
    $session_username = $result['username'];

    $data = array(
        "user" => $session_username,
        "type" => "DELETE",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => $_SERVER['REMOTE_ADDR'],
        "text" => "You deleted $username!"
    );
    $db->insert("activity", $data);

    $data = array(
        "user" => $username,
        "type" => "AUTHORIZE",
        "date" => date("Y-m-d H:i:s"),
        "address_ip" => "Unknown",
        "text" => "$session_username deleted you!"
    );
    $db->insert("activity", $data);

    $subjcet_header = "Human Resources Team";
    $subject = "Human Resources Team";
    $message = "<b>Account Delete</b><br><br><b>$session_username</b> was deleted your account <b>$username</b>!<br>Link to presence site: <a href='https://presence.dev-hub.ro/'>https://presence.dev-hub.ro/</a>!<br><br>Thanks for collaboration!";
    $send_to_email = $result1['email'];
    sendMail($subject_header, $send_to_email, $subject, $message);

    echo json_encode($result1);
?>