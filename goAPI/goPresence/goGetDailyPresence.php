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

    $start_date_sec = strtotime($start_date);
    $end_date_sec = strtotime($end_date);
    $end_date_sec += 86399;
    
    $query = "SELECT 
        vp.user_id,
        DATE(FROM_UNIXTIME(vp.leave_time)) AS date,
        vp.username AS name,
        SUM(vp.total_time) AS seconds
    FROM 
        voice_presence vp
    LEFT JOIN 
        users u ON u.id = vp.user_id 
    WHERE 
        vp.join_time >= $start_date_sec
        AND vp.leave_time <= $end_date_sec 
        $where_string
    GROUP BY 
        vp.user_id, DATE(FROM_UNIXTIME(vp.leave_time))
    ORDER BY 
        DATE(FROM_UNIXTIME(vp.leave_time));
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