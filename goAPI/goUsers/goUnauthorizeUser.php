<?php
    require("../config.php");
    require("../goFunctions.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];

    $data = array(
        "account_confirm" => 0,
	    "discord_user_id" => 0,
        "roles" => json_encode([])
    );
    $db->where("id", $user_id);
    $result1 = $db->update("users", $data);

    $session_user_id = $_REQUEST['session_user_id'];

    $db->where('id', $user_id);
    $result2 = $db->getOne("users", ['username', 'email']);
    $username = $result2['username'];

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

    $subjcet_header = "Human Resources Team";
    $subject = "Human Resources Team";
    $message = "<b>Account Authorize</b><br><br><b>$session_username</b> was unauthorized your account <i>$username</i>!<br><br>Welcome!";
    $send_to_email = $result2['email'];
    sendMail($subject_header, $send_to_email, $subject, $message);

    echo json_encode($result1);
?>
