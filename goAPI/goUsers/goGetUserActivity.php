<?php
    require("../config.php");
    $db = new Database();

    $user = $_REQUEST['user'];
    $query = "SELECT * FROM activity WHERE user='$user' ORDER BY date DESC";
    $activity = $db->query($query);

    $dataType = [];
    $dataDate = [];
    $dataIP = [];
    
    foreach ($activity as $my_activity) {
        $dataType[] = $my_activity['type'];
        $dataDate[] = $my_activity['date'];
        $dataIP[] = $my_activity['address_ip'];
        $dataID[] = $my_activity['id'];
    }

    $data = array(
        "type" => $dataType,
        "ip" => $dataIP,
        "date" => $dataDate,
        "id" => $dataID,
    );

    echo json_encode($data);
?>