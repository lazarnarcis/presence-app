<?php
    require("../config.php");
    $db = new Database();

    $username = $_REQUEST['username'];

    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];

    $where_string = NULL;
    if ($username != "") {
        $where_string .= " AND users.name LIKE '%$username%' ";
    }
    $query = "SELECT presence.user_id, presence.date, users.name, presence.seconds FROM presence LEFT JOIN users ON users.id=presence.user_id WHERE presence.date BETWEEN '$start_date' AND '$end_date' $where_string GROUP BY users.id, presence.date ORDER BY presence.date";
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