<?php
    session_start();
    
    require("APIHandler.php");
    $api = new APIHandler();

    $users = $api->getUsers();

    $data = [];
    for ($i = 0; $i < count($users['id']); $i++) {
        $user = [];
        array_push($user, $users['id'][$i]);
        array_push($user, $users['name'][$i]);
        array_push($user, $users['username'][$i]);
        array_push($user, $users['email'][$i]);

        array_push($data, $user);
    }

    echo json_encode($data);
?>