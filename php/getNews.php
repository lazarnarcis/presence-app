<?php
    require("APIHandler.php");
    require("functions.php");

    $api = new APIHandler();
    $data = $api->getNews();

    echo json_encode($data['news']);
?>