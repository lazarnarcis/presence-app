<?php
    require("../config.php");
    $db = new Database();

    $query = "select * from public_holidays;";
    $users = $db->query($query);

    $data = [];
    if (count($users)) {
        foreach ($users as $user) {
            $dataUserID[] = $user['id'];
            $dataName[] = $user['name'];
            $dataDate[] = $user['date'];
        }

        $data = array(
            "id" => $dataUserID,
            "name" => $dataName,
            "date" => $dataDate,
        );
    }

    echo json_encode($data);
?>