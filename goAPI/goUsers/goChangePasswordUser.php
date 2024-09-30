<?php
    session_start();
    require("../config.php");
    require("../goFunctions.php");
    $db = new Database();

    $uniqueid = $_REQUEST['uniqueid'];
    $password = $_REQUEST['password'];

    $query = "select * from forgot_password where uniqueid='$uniqueid'";
    $forgot_password = $db->query($query);

    $err_message = 1;
    if (is_array($forgot_password) && count($forgot_password) > 0) {
        $forgot_password = $forgot_password[0];

        $user_id = $forgot_password['userid'];
        $data = [
            "password" => password_hash($password, PASSWORD_DEFAULT),
        ];
        $db->where("id", $user_id);
        $db->update("users", $data);

        $db->where("uniqueid", $uniqueid);
        $db->deleteRow("forgot_password");
    } else {
        $err_message = "Doesn't exist request password for this uniqueid: $uniqueid";
    }

    echo json_encode($err_message);
?>