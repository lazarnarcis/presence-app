<?php
    session_start();
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();
    $year = $_POST['year'];

    $public_holidays = $api->getPublicHolidays($year);
    $data = [];
    if (count($public_holidays)) {
        for ($i = 0; $i < count($public_holidays['id']); $i++) {
            $name = [];
            array_push($name, $public_holidays['id'][$i]);
            array_push($name, $public_holidays['name'][$i]);
            array_push($name, $functions->dateName($public_holidays['date'][$i]));
            array_push($data, $name);
        }
    }

    echo json_encode($data);
?>