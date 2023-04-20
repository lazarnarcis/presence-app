<?php
    require("../config.php");
    $db = new Database();

    $db->where("name", "news");
    $qnews = $db->select("options");
    $news = $qnews[0]['text'];

    $data = array(
        "news" => $news
    );

    echo json_encode($data);
?>