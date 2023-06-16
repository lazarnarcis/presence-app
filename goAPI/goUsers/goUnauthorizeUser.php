<?php
    require("../config.php");
    $db = new Database();

    $user_id = $_REQUEST['user_id'];
    $query = "UPDATE users SET account_confirm=0 WHERE id='$user_id'";
    $result = $db->query($query);

    echo json_encode($result);
?>