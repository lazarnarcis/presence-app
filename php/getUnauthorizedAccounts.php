<?php
    session_start();
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $session_user_info = $api->getUserInfo($_SESSION['user_id']);
    $functions = new Functions();

    $unauthorized_accounts = $api->getUnauthorizedAccounts();
    $data = [];
    if (count($unauthorized_accounts)) {
        for ($i = 0; $i < count($unauthorized_accounts['id']); $i++) {
            $user_id = $unauthorized_accounts['id'][$i];
            $button_authorize = NULL;
            if ($unauthorized_accounts['account_confirm'][$i] == 1) {
                if ($session_user_info['admin'] == 2 && $_SESSION['user_id'] != $user_id) {
                    $button_authorize = "<button type='button' class='btn btn-danger unauthorize_user' data-user-id='$user_id'>Unauthorize</button>";
                } else {
                    $button_authorize = "<button type='button' class='btn btn-danger disabled'>Authorized</button>";
                }
            } else {
                if ($session_user_info['admin'] == 2) {
                    $button_authorize = "<button class='btn btn-success authorize_user' data-user-id='$user_id'>Authorize</button>";
                } else {
                    $button_authorize = "<button class='btn btn-success disabled'>Unauthorized</button>";
                }
            }
            $name = [];
            $click_user = "<a href='profile.php?id=$user_id'>".$unauthorized_accounts['username'][$i]."</a>";
            $roles = json_decode($unauthorized_accounts['roles'][$i]);
            $first_role = NULL;
            if (count($roles)) {
                $first_role = $roles[0];
            }
            array_push($name, $user_id);
            array_push($name, $click_user);
            array_push($name, $unauthorized_accounts['name'][$i]);
            array_push($name, $first_role);
            array_push($name, $unauthorized_accounts['date'][$i]);
            array_push($name, $button_authorize);
    
            array_push($data, $name);
        }
    }

    echo json_encode($data);
?>