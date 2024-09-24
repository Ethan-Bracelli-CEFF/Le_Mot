<?php
session_start();
require_once('database.php');
$db = new Database();

if (isset($_POST['player_id']) && isset($_POST['game_id'])) {
    $playerId = $_POST['player_id'];
    $gameId = $_POST['game_id'];
    
    // Retirer le joueur de la partie avec l'ID du jeu
    $db->removePlayerFromGame($gameId, $playerId);

    // Vérifie si l'utilisateur retiré est celui actuellement connecté
    if ($playerId == $_SESSION['user_id']) {
        // Définit un message de session pour l'utilisateur kické
        $_SESSION['kicked'] = "Vous avez été expulsé de la partie.";
        header('Location: main.php');
        exit();
    } else {
        // Redirige l'hôte ou l'utilisateur actuel vers la page de la partie
        header('Location: waiting_room.php'); 
        exit();
    }
}
?>
