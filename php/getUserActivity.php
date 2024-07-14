<?php
    session_start();
    
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $user = $_POST['user'];
    $user_activity = $api->getUserActivity($user);

    $data = [];
    if (count($user_activity)) {
        for ($i = 0; $i < count($user_activity['id']); $i++) {
            $activity = [];
            array_push($activity, $user_activity['date'][$i]);
            array_push($activity, $user_activity['type'][$i]);
            array_push($activity, $user_activity['ip'][$i]);
            array_push($activity, $user_activity['text'][$i]);
    
            array_push($data, $activity);
        }
    }

    echo json_encode($data);
?>