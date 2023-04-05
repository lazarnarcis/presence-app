<?php
    require("../config.php");
    $db = new Database();

    $users = $db->select("users");

    foreach ($users as $user) {
        $dataUserID[] = $user['id'];
        $dataName[] = $user['name'];
        $dataUsername[] = $user['username'];
        $dataEmail[] = $user['email'];
        $dataPassword[] = $user['password'];
    }

    $data = array(
        "id" => $dataUserID,
        "name" => $dataName,
        "username" => $dataUsername,
        "email" => $dataEmail,
        "password" => $dataPassword
    );

    echo json_encode($data);
?>