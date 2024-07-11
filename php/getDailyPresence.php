<?php
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $username = $_POST['username'];
    $start_date = $_POST['start_date'];
    $end_date = $_POST['end_date'];
    $daily_presence = $api->getDailyPresence($username, $start_date, $end_date);

    $data = [];
    for ($i = 0; $i < count($daily_presence['id']); $i++) {
        $presence = [];
        array_push($presence, $daily_presence['id'][$i]);
        array_push($presence, $daily_presence['name'][$i]);
        array_push($presence, $functions->dateName($daily_presence['date'][$i]));
        array_push($presence, $functions->transformSeconds($daily_presence['seconds'][$i]));

        array_push($data, $presence);
    }

    echo json_encode($data);
?>