<?php
$lockFile = '/tmp/auto_cleanup.lock';
if (file_exists($lockFile)) {
    echo "Script already running. Exiting...\n";
    exit;
}
file_put_contents($lockFile, getmypid());
session_start();
require('/var/www/html/presence.dev-hub.ro/goAPI/config.php');

$db = new Database();

$query = "DELETE FROM forgot_password WHERE created_at < NOW() - INTERVAL 15 MINUTE";
$db->query($query);

error_log("Deleted rows older than 15 minutes from forgot_password!!!");
unlink($lockFile);
?>
