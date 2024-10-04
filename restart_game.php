<?php session_start();
require_once('database.php');
$db = new Database();

$game = $_SESSION['game'];
$gameId = $game['id_game'];

$db->stopGame($gameId);
header("Location: waiting_room.php");