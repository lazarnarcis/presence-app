<?php
    session_start();
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $discord_members = $api->getDiscordMembers();
    $data = [];
    for ($i = 0; $i < count($discord_members); $i++) {
        $member = [];
        array_push($member, $discord_members[$i]['user_id']);
        array_push($member, $discord_members[$i]['username']);
        array_push($member, $discord_members[$i]['nickname']);
        array_push($member, $discord_members[$i]['roles']);

        array_push($data, $member);
    }

    echo json_encode($data);
?>