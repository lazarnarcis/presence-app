<?php
    require("../config.php");
    $db = new Database();

    $query = "SELECT
                news.id,
                users.name,
                news.text,
                news.created_at,
                users.id as user_id
            FROM
                news
                left join 
                users on users.id=news.created_by_user_id
            ORDER BY created_at DESC;";
    $news = $db->query($query);

    $data = [];
    if (count($news)) {
        foreach ($news as $ns) {
            $dataID[] = $ns['id'];
            $dataName[] = $ns['name'];
            $dataText[] = $ns['text'];
            $dataCreatedAt[] = $ns['created_at'];
            $dataUserId[] = $ns['user_id'];
        }

        $data = array(
            "id" => $dataID,
            "name" => $dataName,
            "text" => $dataText,
            "created_at" => $dataCreatedAt,
            "user_id" => $dataUserId
        );
    }

    echo json_encode($data);
?>