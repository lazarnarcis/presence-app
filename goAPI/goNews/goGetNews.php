<?php
    require("../config.php");
    $db = new Database();

    $db->where("name", "news");
    $qnews = $db->getOne("options");
    $news = $qnews['text'];

    $data = array(
        "news" => $news
    );

    echo json_encode($data);
?>