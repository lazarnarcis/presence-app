<?php
    session_start();
    
    require("APIHandler.php");
    require("functions.php");

    $news = $_POST['news'];
    $api = new APIHandler();
    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $data = $api->updateNews($news, $session_user_info['name'], $_SESSION['user_id']);

    echo json_encode($data);
?>