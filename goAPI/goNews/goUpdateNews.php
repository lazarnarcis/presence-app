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
    $qnews = $db->getOne("options");
    $news = $qnews['text'];

    $data = array(
        "news" => $news
    );

    echo json_encode($data);
?>