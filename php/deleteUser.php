<?php
    session_start();
    require("APIHandler.php");
    $api = new APIHandler();

    $user_id = $_POST['user_id'];
    $delete_user = $api->deleteUser($user_id, $_SESSION['user_id']);
    
    echo json_encode($delete_user);
?>