<?php
    require("../config.php");
    $db = new Database();

    $current_month = date("Y-m");
    $query = "SELECT SUM(presence.seconds) AS seconds, presence.user_id, users.name FROM presence LEFT JOIN users ON users.id=presence.user_id WHERE presence.date LIKE '%$current_month%' GROUP BY users.id;";
    $presence = $db->query($query);

    $dataID = [];
    $dataDate = [];
    $dataName = [];
    $dataPresence = [];
    
    foreach ($presence as $user) {
        $dataID[] = $user['user_id'];
        $dataDate[] = $current_month;
        $dataName[] = $user['name'];
        $dataPresence[] = $user['seconds'];
    }

    $data = array(
        "id" => $dataID,
        "name" => $dataName,
        "date" => $dataDate,
        "presence" => $dataPresence,
    );

    echo json_encode($data);
?>