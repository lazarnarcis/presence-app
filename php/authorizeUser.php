<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $discord_user_id = $_POST['discord_user_id'];
    $authorize_user = $api->authorizeUser($user_id, $_SESSION['user_id'], $discord_user_id);
    
    echo json_encode($authorize_user);
?>