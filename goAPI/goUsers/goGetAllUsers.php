<?php
    require("../config.php");
    $db = new Database();

    $columns = array(
        "name", 
        "id", 
        "username", 
        "email",
        "role"
    );
    $users = $db->select("users", $columns);

    foreach ($users as $user) {
        $dataUserID[] = $user['id'];
        $dataName[] = $user['name'];
        $dataUsername[] = $user['username'];
        $dataEmail[] = $user['email'];
        $dataRole[] = $user['role'];
    }

    $data = array(
        "id" => $dataUserID,
        "name" => $dataName,
        "username" => $dataUsername,
        "email" => $dataEmail,
        "role" => $dataRole,
    );

    echo json_encode($data);
?>