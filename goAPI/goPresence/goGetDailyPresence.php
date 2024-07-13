<?php
    require("../config.php");
    $db = new Database();

    $username = $_REQUEST['username'];

    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];

    $where_string = NULL;
    if ($username != "") {
        $where_string .= " AND vp.username LIKE '%$username%' ";
    }


    $query = "SELECT 
        vp.user_id,
        vp.date,
        vp.username AS name,
        SUM(vp.total_time) AS seconds
    FROM 
        voice_presence vp
    LEFT JOIN 
        users u ON u.id = vp.user_id 
    WHERE 
        vp.date >= '$start_date'
        AND vp.date <= '$end_date'
        $where_string
    GROUP BY 
        vp.user_id, vp.date
    ORDER BY 
        vp.date;
    ";

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