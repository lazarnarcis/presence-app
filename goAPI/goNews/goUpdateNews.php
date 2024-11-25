<?php
    require("../config.php");
    require("../goFunctions.php");
    $db = new Database();

    $news = $_REQUEST['news'];
    $session_user_name = $_REQUEST['session_user_name'];
    $session_user_id = $_REQUEST['session_user_id'];
    $db->where("name", "news");
    $data = [
        "text" => $news
    ];
    $db->update("options", $data);

    $data = [
        'text' => $news,
        "created_by_user_id" => $session_user_id,
    ];
    $db->insert("news", $data);

    $db->where("name", "news");
    $qnews = $db->getOne("options");
    $news = $qnews['text'];

    $subjcet_header = "Human Resources Team";
    $subject = "Human Resources Team";
    $message = "<b>News</b> was updated by <b>$session_user_name</b>: $news<br><br>King regards!";

    $query = 'select email from users where account_confirm = 1';
    $all_users = $db->query($query);
    if (count($all_users)) {
        foreach ($all_users as $user) {
            $send_to_email = $user['email'];
            sendMail($subject_header, $send_to_email, $subject, $message);
        }
    }

    $data = array(
        "news" => $news
    );

    echo json_encode($data);
?>