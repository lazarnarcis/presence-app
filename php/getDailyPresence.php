<?php
    session_start();
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $channel = $_POST['channel'];
    $daily_presence = $api->getDailyPresence($start_date, $end_date, $channel);

    $data = [];
    for ($i = 0; $i < count($daily_presence['id']); $i++) {
        $presence = [];
        $seconds_used = $functions->transformSeconds($daily_presence['seconds'][$i]);
        list($hours, $minutes, $seconds) = explode(':', $seconds_used);
        $seconds_used = "{$hours}h {$minutes}m {$seconds}s";
        array_push($presence, $daily_presence['id'][$i]);
        array_push($presence, $daily_presence['name'][$i]);
        array_push($presence, $functions->dateName($daily_presence['date'][$i]));
        array_push($presence, $seconds_used);

        array_push($data, $presence);
    }

    echo json_encode($data);
?>