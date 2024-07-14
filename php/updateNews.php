<?php
    session_start();
    
    require("APIHandler.php");
    require("functions.php");

    $news = $_POST['news'];
    $api = new APIHandler();
    $data = $api->updateNews($news);

    echo json_encode($data);
?>