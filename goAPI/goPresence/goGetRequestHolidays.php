<?php
    require("../config.php");
    $db = new Database();

    $name = $_REQUEST['name'];
    $session_user_id = $_REQUEST['session_user_id'];
    $admin = $_REQUEST['admin'];
    
    $conditions = "";
    if ($admin == 0) {
        $conditions .= " user_id='$session_user_id' ";
    } else {
        if (!empty($name)) {
            $conditions .= " user_id='$name' ";
        } else {
            $conditions .= " user_id='$session_user_id' ";
        }
    }
    $query = "select request_holidays.*, users.name from request_holidays left join users on users.id=request_holidays.user_id where $conditions;";
    $request_holidays = $db->query($query);

    $query = "select * from public_holidays";
    $public_holidays = $db->query($query);

    $conditions = "";
    if ($admin == 0) {
        $conditions .= " id='$session_user_id' ";
    } else {
        if (!empty($name)) {
            $conditions .= " id='$name' ";
        } else {
            $conditions .= " id='$session_user_id' ";
        }
    }
    $query = "select * from users where $conditions limit 1;";
    $user_get = $db->query($query);
    
    $data = array(
        "response" => "success",
        "data" => $request_holidays,
        "public_holidays" => $public_holidays,
        "holidays_left" => $user_get[0]['holidays_left']
    );

    echo json_encode($data);
?>