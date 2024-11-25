<?php
    require("../config.php");
    $db = new Database();

    $d_members = $db->select("discord_members"); 

    echo json_encode($d_members);
?>