<?php
    require("../config.php");
    $db = new Database();

    $name = $_REQUEST['user'];
    $session_user_id = $_REQUEST['session_user_id'];
    $conditions = NULL;
    if (!empty($name)) {
        $conditions .= " user_id='$name' ";
    } else {
        $conditions .= " user_id='$session_user_id' ";
    }
    $query = "SELECT * FROM request_holidays WHERE $conditions ORDER BY request_at DESC";
    $activity = $db->query($query);

    $dataDate = [];
    $dataId = [];
    $dataYear = [];
    $dataMonth = [];
    $dataDay = [];
    $dataStatus = [];
    $dataReason = [];
    $dataType = [];
    $dataRequestAt = [];
    $data = [];
    if (count($activity)) {
        foreach ($activity as $my_activity) {
            $dataId[] = $my_activity['id'];
            $dataDate[] = $my_activity['request_at'];
            $dataYear[] = $my_activity['year'];
            $dataMonth[] = $my_activity['month'];
            $dataDay[] = $my_activity['day'];
            $dataStatus[] = $my_activity['status'];
            $dataReason[] = $my_activity['reason'];
            $dataType[] = $my_activity['type'];
        }
    
        $data = array(
            "id" => $dataId,
            "request_at" => $dataDate,
            "year" => $dataYear,
            "month" => $dataMonth,
            "day" => $dataDay,
            "status" => $dataStatus,
            "reason" => $dataReason,
            "type" => $dataType,
        );
    }

    echo json_encode($data);
?>