<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $name = $_POST['name'];
    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $result = $api->getRequestHolidays($_SESSION['user_id'], $session_user_info['admin'], $name);
    $all_data = [];
    $data = [];

    $holidays_result = $result['data'];
    if (count($holidays_result)) {
        foreach ($holidays_result as $hr) {
            $data[$hr['year'].'-'.$hr['month'].'-'.$hr['day']] = ['status' => $hr['status'], 'user_id' => $hr['user_id'], 'user' => $hr['name'], 'type' => $hr['type'], 'reason' => $hr['reason']];
        }
    }

    $pholidays_result = $result['public_holidays'];
    if (count($pholidays_result)) {
        foreach ($pholidays_result as $hr) {
            $data[$hr['date']] = ['status' => "holiday", 'description' => $hr['name']];
        }
    }
    $all_data['data'] = $data;
    $all_data['holidays_left'] = $result['holidays_left'];

    echo json_encode($all_data);
?>