<?php session_start();
require_once('database.php');
$db = new Database();

$userId = $_POST['player_id'];
$gameId = $_POST['game_id'];

$gamePlayers = $db->getPlayersByGame($gameId);

foreach ($gamePlayers as $player){
    $playerId = $player['id_utilisateur'];

    $db->removePlayerFromGame($gameId, $playerId);
}

$db->deletegame($gameId);

header("Location: main.php");
exit();
