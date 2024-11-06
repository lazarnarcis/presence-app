<?php
    session_start();
    
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $user = $_POST['user'];
    $user_activity = $api->getHolidaysHistory($user, $_SESSION['user_id']);

    $data = [];
    if (count($user_activity)) {
        for ($i = 0; $i < count($user_activity['id']); $i++) {
            $activity = [];
            $initial_date = new DateTime($user_activity['year'][$i]."-".$user_activity['month'][$i]."-".$user_activity['day'][$i]);
            $new_date = $initial_date->format('d M Y');
            array_push($activity, $user_activity['type'][$i]);
            array_push($activity, $user_activity['status'][$i]);
            array_push($activity, $new_date);
            array_push($activity, $user_activity['reason'][$i]);
            array_push($activity, $user_activity['request_at'][$i]);
    
            array_push($data, $activity);
        }
    }

    echo json_encode($data);
?>