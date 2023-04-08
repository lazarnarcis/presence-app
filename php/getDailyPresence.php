<?php
    require("APIHandler.php");
    $api = new APIHandler();

    $daily_presence = $api->getDailyPresence();

    $data = [];
    for ($i = 0; $i < count($daily_presence['id']); $i++) {
        $presence = [];
        array_push($presence, $daily_presence['name'][$i]);
        array_push($presence, $daily_presence['date'][$i]);
        array_push($presence, $daily_presence['presence'][$i]);

        array_push($data, $presence);
    }

    echo json_encode($data);
?>