<?php
include 'Bot.php';
$msg = json_decode(file_get_contents('php://input'))->msg;
$bot = new Bot();
echo $bot->sendMsg($msg);
?>