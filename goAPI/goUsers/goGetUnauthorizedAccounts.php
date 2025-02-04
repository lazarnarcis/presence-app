<?php
    require("../config.php");
    $db = new Database();

    $query = "SELECT
                users.id,
                users.name,
                users.username,
                users.date AS date,
                users.account_confirm,
                users.roles,
                users.admin
            FROM
                users
            ORDER BY users.date DESC;";
    $users = $db->query($query);

    $data = [];
    if (count($users)) {
        foreach ($users as $user) {
            $dataUserID[] = $user['id'];
            $dataName[] = $user['name'];
            $dataUsername[] = $user['username'];
            $dataDate[] = $user['date'];
            $dataAccountConfirmation[] = $user['account_confirm'];
            $dataRoles[] = $user['roles'];
            $dataAdmin[] = $user['admin'];
        }

        $data = array(
            "id" => $dataUserID,
            "name" => $dataName,
            "username" => $dataUsername,
            "date" => $dataDate,
            "account_confirm" => $dataAccountConfirmation,
            "roles" => $dataRoles,
            "admin" => $dataAdmin
        );
    }

    echo json_encode($data);
?>