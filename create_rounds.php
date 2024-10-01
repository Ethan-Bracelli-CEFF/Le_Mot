<?php
session_start();
require_once('database.php');
$db = new Database();
$game = $_SESSION['game'];

// Vérifier si les mots utilisés existent déjà dans la session, sinon les initialiser
if (!isset($_SESSION['mots_utilises'])) {
    $_SESSION['mots_utilises'] = [];
}
$mots_utilises = &$_SESSION['mots_utilises']; // Passer par référence pour garder l'état

function getRandomWord($difficulty, &$mots_utilises)
{
    // Listes de mots par difficulté
    if ($difficulty === "easy") {
        $liste_mot = [
            "arbre", "blanc", "boire", "boule",
            "chant", "corps", "danse", "douce", "envie",
            "eclat", "femme", "flote", "fruit",
            "hatez", "louer", "mètre", "paume",
            "plage", "porte", "sable", "sauce",
            "table", "valet", "wagon", "sucre", 
            "bande", "pomme", "adieu", 
            "belle", "chose", "drape", "foyer", "globe",
            "grace", "signe", "zebre", "yacht",
            "grain", "force", "hiver", "biche",
            "maman", "plume", "reine", "salut",
            "avril", "ferme", "creme", "valet",
            "vivre", "peine", "tache", "singe",
            "neige", "sourd", "garde", "haine", "jaune",
            "larme", "marin", "soupe", "tasse",
            "crise", "image", "lutte", "tapis", 
            "cacao", "parle", "songe", "fille", 
            "tigre", "vigne", "sorte", "pluie"
        ];
        
    } else if ($difficulty === "normal") {
        $liste_mot = [
            "aboyer", "agacer", "alarme",
            "baiser", "banque", "blouse", "bougie", "briser",
            "chaise", "cigale",
            "ciseau", "coller", "désert",
            "écrire", "epices", "fermer",
            "flamme", "fraise", "gagner",
            "garcon", "glacer", "joueur",
            "jungle", "laitue", "lavage", "legume", "manche",
            "marche", "marier", "manger", "mentir", "monter",
            "mousse", "nature", "obscur", "orange",
            "panier", "parfum", "pattes", "plante",
            "prince", "ranger", "regret",
            "risque", "rouler", "salade",
            "souper", "tonner",
            "tramer", "triste",
            "valise", "vendre", "vibrer", "violet",
            "vortex", "voyage", "zodiac",
            "bambou", "cactus", "cerise"
        ];
        
    } else if ($difficulty === "hard") {
        $liste_mot = [
            "fidelite", "enrouler", "anatomie",
            "chiffres", "combiner", "huitième", "bataille", "materiel",
            "blizzard", "admirant", "visiteur", "obstacle", "aerienne",
            "chocolat", "marchand", "flottant", "surprise", "naviguer",
            "coupable", "eclairer", "albatros", "analogie", "triangle",
            "detecter", "policier", "vocation", "allumage",
            "ecrivain", "bananier", "parfumee", "attendri", "jalousie",
            "regarder", "prochain",
        ];
        
        
    }

    // Boucle pour s'assurer de ne pas réutiliser un mot déjà utilisé
    do {
        $mot = $liste_mot[array_rand($liste_mot)];
    } while (in_array($mot, $mots_utilises)); // Tant que le mot est déjà utilisé, on en prend un autre

    // Ajouter le mot aux mots utilisés
    $mots_utilises[] = $mot;

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
    $mot = getRandomWord($difficulty, $mots_utilises);
    $db->createRound($mot, $id_game, $i+1);
}

$firstRoundId = $db->getRoundIdByGameAndNumber($id_game, 1);
$db->setRoundForUser($firstRoundId['id_round'], $_SESSION['user_id']);

// Redirection vers le lobby
header('Location: lobby.php');
?>
