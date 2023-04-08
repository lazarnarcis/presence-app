<?php
    require("../config.php");
    $db = new Database();

    $current_date = date("Y-m-d");
    $query = "SELECT presence.user_id, presence.date, users.name, presence.seconds FROM presence LEFT JOIN users ON users.id=presence.user_id WHERE presence.date = '$current_date'";
    $presence = $db->query($query);

    $dataID = [];
    $dataDate = [];
    $dataName = [];
    $dataPresence = [];
    
    foreach ($presence as $user) {
        $dataID[] = $user['user_id'];
        $dataDate[] = $user['date'];
        $dataName[] = $user['name'];
        $dataPresence[] = transformSeconds($user['seconds']);
    }

    $data = array(
        "id" => $dataID,
        "name" => $dataName,
        "date" => $dataDate,
        "presence" => $dataPresence,
    );

    function transformSeconds ($seconds) {
        return gmdate("H:i:s", $seconds);
    }

    echo json_encode($data);
?>