<?php
session_start();
require('/var/www/html/presence.dev-hub.ro/goAPI/config.php');
$db = new Database();

$query = "DELETE FROM forgot_password";
$db->query($query);
error_log("Deleted all rows from forgot_password!!!");
?>
