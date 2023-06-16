<?php
  session_start();
  if (!isset($_SESSION['logged']) || $_SESSION['logged'] != true) {
    header("location: login.php");
    exit();
  }

  require("./php/UIHandler.php");
  $ui = new UIHandler();
  require("./php/APIHandler.php");
  $api = new APIHandler();
  $session_user_info = $api->getUserInfo($_SESSION['user_id']);
  if ($session_user_info['account_confirm'] == 1) {
    header("location: index.php");
    exit();
  }
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Restricted account</title>
</head>
<body>
    <h1 style="text-align: center;">Please contact site Administrator to authorize your account!</h1>
</body>
</html>