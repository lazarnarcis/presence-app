<?php
    require("APIHandler.php");
    require("functions.php");
    $api = new APIHandler();
    $functions = new Functions();

    $unauthorized_accounts = $api->getUnauthorizedAccounts();
    
    $data = [];
    if (count($unauthorized_accounts)) {
        for ($i = 0; $i < count($unauthorized_accounts['id']); $i++) {
            $user_id = $unauthorized_accounts['id'][$i];
            $button_authorize = NULL;
            if ($unauthorized_accounts['account_confirm'][$i] == 1) {
                $button_authorize = "<button type='button' class='btn btn-success' disabled>Authorized</button>";
            } else {
                $button_authorize = "<button class='btn btn-danger authorize_user' data-user-id='$user_id'>Authorize</button>";
            }
            $name = [];
            array_push($name, $user_id);
            array_push($name, $unauthorized_accounts['username'][$i]);
            array_push($name, $unauthorized_accounts['name'][$i]);
            array_push($name, $unauthorized_accounts['date'][$i]);
            array_push($name, $button_authorize);
    
            array_push($data, $name);
        }
    }

    echo json_encode($data);
?>