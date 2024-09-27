<?php session_start();
require_once('database.php');
$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $id_game = $_POST['id_game'];
    $game = $db->getGameById($id_game);

    if($game['started'] === 0){
        $_SESSION['game'] = $game;
        $db->updatePlayerGame($_SESSION['user_id'], $game['id_game']);
        header('Location: waiting_room.php');
    } else {
        echo "<script>alert('Cette partie a déjà commencé !');</script>";
        header('Location: main.php');
    }
}
