<?php
    session_start();
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $news = $api->getAllNews();
    $data = [];
    if (count($news)) {
        for ($i = 0; $i < count($news['id']); $i++) {
            $name = [];
            $click_user = "<a href='profile.php?id=".$news['user_id'][$i]."'>".$news['name'][$i]."</a>";
            array_push($name, $click_user);

            $date = new DateTime($news['created_at'][$i]);
            $new_date_format = $date->format('d M Y, H:i');

            array_push($name, $new_date_format);
            array_push($name, $news['text'][$i]);
    
            array_push($data, $name);
        }
    }

    echo json_encode($data);
?>