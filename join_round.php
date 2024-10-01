<?php
session_start();
require_once('database.php');
$db = new Database();
$game = $_SESSION['game'];

$id_game = $game['id_game'];
$game = $db->getGameById($id_game);

$_SESSION['game'] = $game;


$firstRoundId = $db->getRoundIdByGameAndNumber($id_game, 1);
$db->setRoundForUser($firstRoundId['id_round'], $_SESSION['user_id']);

// Redirection vers le lobby
header('Location: lobby.php');
?>
