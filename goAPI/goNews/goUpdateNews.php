<?php
    require("../config.php");
    $db = new Database();

    $news = $_REQUEST['news'];
    $db->where("name", "news");
    $data = [
        "text" => $news
    ];
    $db->update("options", $data);

    $db->where("name", "news");
    $qnews = $db->select("options");
    $news = $qnews[0]['text'];

    $data = array(
        "news" => $news
    );

    echo json_encode($data);
?>