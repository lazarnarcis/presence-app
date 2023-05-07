<?php
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];

    $current_date = date("Y-m-d");
    $where_string = NULL;
    if ($user_id != "") {
        $where_string .= " AND users.id=$user_id ";
    }
    $query = "SELECT presence.user_id, presence.date, users.name, presence.seconds FROM presence LEFT JOIN users ON users.id=presence.user_id WHERE presence.date = '$current_date' $where_string GROUP BY users.id";
    $presence = $db->query($query);

    $dataID = [];
    $dataDate = [];
    $dataName = [];
    $dataSeconds = [];
    
    foreach ($presence as $user) {
        $dataID[] = $user['user_id'];
        $dataDate[] = $user['date'];
        $dataName[] = $user['name'];
        $dataSeconds[] = $user['seconds'];
    }

    $data = array(
        "id" => $dataID,
        "name" => $dataName,
        "date" => $dataDate,
        "seconds" => $dataSeconds,
    );

    echo json_encode($data);
?>