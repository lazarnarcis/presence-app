<?php
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $authorize_user = $api->unauthorizeUser($user_id);
    
    echo json_encode($authorize_user);
?>