<?php
    require("../config.php");
    $db = new Database();

    $start_date = $_REQUEST['start_date'];
    $end_date = $_REQUEST['end_date'];

    $channel = $_REQUEST['channel'];

    $where_string = NULL;

    if (!empty($channel)) {
        $where_string .= " AND vp.channel_name = '$channel' ";
    }

    $query = "SELECT 
        u.id as user_id,
        vp.date,
        u.name AS name,
        SUM(vp.total_time) AS seconds
    FROM 
        voice_presence vp
    JOIN 
        users u ON u.discord_user_id = vp.user_id  
    WHERE 
        (vp.date >= '$start_date'
        AND vp.date <= '$end_date')
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