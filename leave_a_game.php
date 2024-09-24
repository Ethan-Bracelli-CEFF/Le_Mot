<?php session_start();
require_once('database.php');
$db = new Database();

$userId = $_POST['player_id'];
$gameId = $_POST['game_id'];


$db->removePlayerFromGame($gameId, $userId);

header("Location: main.php");
exit();
