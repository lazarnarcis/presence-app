<?php
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $username = $_POST['username'];
    $daily_presence = $api->getDailyPresence($username);

    $data = [];
    for ($i = 0; $i < count($daily_presence['id']); $i++) {
        $presence = [];
        array_push($presence, "<a href='profile.php?id=".$daily_presence['id'][$i]."'>".$daily_presence['name'][$i]."</a>");
        array_push($presence, $functions->dateName($daily_presence['date'][$i]));
        array_push($presence, $functions->transformSeconds($daily_presence['seconds'][$i]));

        array_push($data, $presence);
    }

    echo json_encode($data);
?>