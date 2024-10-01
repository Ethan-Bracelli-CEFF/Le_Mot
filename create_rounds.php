<?php session_start();
require_once('database.php');
$db = new Database();
$game = $_SESSION['game'];

function getRandomWord($difficulty)
{
    if ($difficulty === "easy") {
        $liste_mot = [
            "chat",
            "chien",
            "maison",
            "livre",
            "soleil",
            "fleur",
            "table",
            "porte",
            "pomme",
            "arbre"
        ];
    } else if ($difficulty === "normal") {
        $liste_mot = [
            "ordinateur",
            "montagne",
            "plage",
            "musique",
            "voiture",
            "fenêtre",
            "amitié",
            "étoile",
            "hôpital",
            "travail"
        ];
    } else if ($difficulty === "hard") {
        $liste_mot = [
            "crocodile",
            "architecture",
            "bibliothèque",
            "philosophie",
            "révolution",
            "exemplaire",
            "astronomie",
            "catastrophe",
            "laboratoire",
            "extraordinaire"
        ];
    }

    $mot = $liste_mot[array_rand($liste_mot)];
    return $mot;
}

$id_game = $game['id_game'];
$game = $db->getGameById($id_game);

$db->startGame($id_game);
$game['status'] = 1;
$_SESSION['game'] = $game;
$difficulty = $game['difficulty'];

$nbRound = $game['nbRound'];
for ($i = 0; $i < $nbRound; $i++) {
    $mot = getRandomWord($difficulty);
    $db->createRound($mot, $id_game, $i+1);
}
$firstRoundId = $db->getRoundIdByGameAndNumber($id_game, 1);
$db->setRoundForUser($firstRoundId['id_round'], $_SESSION['user_id']);

header('Location: lobby.php');
