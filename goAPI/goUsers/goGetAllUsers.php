<?php
    require("../config.php");
    $db = new Database();

    $columns = array(
        "name", 
        "id", 
        "username", 
        "email",
        "roles"
    );
    $users = $db->select("users", $columns);

    foreach ($users as $user) {
        $dataUserID[] = $user['id'];
        $dataName[] = $user['name'];
        $dataUsername[] = $user['username'];
        $dataEmail[] = $user['email'];
        $dataRoles[] = $user['roles'];
    }

    $data = array(
        "id" => $dataUserID,
        "name" => $dataName,
        "username" => $dataUsername,
        "email" => $dataEmail,
        "roles" => $dataRoles,
    );

    echo json_encode($data);
?>