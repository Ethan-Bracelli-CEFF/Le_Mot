<?php session_start();
require_once('database.php');
$db = new Database();

$game = $_SESSION['game'];
$gameId = $game['id_game'];
$gameName = $game['name'];
$gameHostId = intval($game['hostId']);
$gameHost = $db->getUser($gameHostId);
$gameCode = $game['code'];

$gameState = $db->isStarted($gameId);

$gamePlayers = $db->getPlayersByGame($gameId);

$leaderboardPlayers = $db->getLeaderboard($gameId);

// Extraire tous les 'id_utilisateur' depuis $gamePlayers
$ids_joueurs = array_column($gamePlayers, 'id_utilisateur');

$postion = 1;

$finished = false;

$playerFinished = 0;

for ($i = 0; $i < count($gamePlayers); $i++){
    if ($gamePlayers[$i]['rounds_id_round'] === 0){
        $playerFinished++;
    }
}

if ($playerFinished === count($gamePlayers)){
    $finished = true;
}

// Vérifier si l'utilisateur connecté est dans cette liste
if (!in_array($_SESSION['user_id'], $ids_joueurs)) {
    header("Location: main.php");
    exit();
}

if ($gameState['status'] === 0) {
    header("Location: waiting_room.php");
    exit();
}


?>
<!doctype html>
<html lang="en">

<head>


    <title>Le Mot</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN" crossorigin="anonymous" />
    <link href="/Le_Mot.css" rel="stylesheet" />
    <script>
        // Fonction qui actualise la page toutes les secondes
        setInterval(function() {
            location.reload();
        }, 5000);
    </script>
</head>


<body class="bg-color">
    <header>
        <div class="container-fluid">
            <div class="row row-header">
                <div class="col-6 mt-3 mx-3">
                    <h1 class="fw-bold text-start MOT-titre">Le Mot</h1>
                </div>

                <div class="col mt-3 mx-3">
                    <h1 class="fw-bold text-end big-username"><?php echo ($_SESSION['username']); ?></h1>
                </div>
            </div>
        </div>
    </header>
    <main>
        <div class="container-fluid">
            <div class="ms-5 row mt-5">
                <div class="col-3 mx-0">
                    <div class="container fond rounded-5 priv-tab">
                        <h1 class="text-center text-tab pt-4" style="margin-bottom: 100px;">Participants</h1>
                        <div class="container">
                            <?php foreach ($gamePlayers as $player): ?>
                                <div class="row">
                                    <div class="col-12 ">
                                        <?php if ($gameHostId !== $player['id_utilisateur']): ?>
                                            <div class="border list-player rounded mb-2">
                                                <form method="post" action="remove_player.php">
                                                    <div class="container">
                                                        <div class="row row-list">
                                                            <div class="col-10 pt-2">
                                                                <?= ($player['username']) ?>
                                                            </div>
                                                            <?php if ($gameHostId === $_SESSION['user_id']): ?>
                                                                <!-- Bouton pour retirer un joueur -->
                                                                <div class="col-1">
                                                                    <input type="hidden" name="player_id" value="<?= htmlspecialchars($player['id_utilisateur']) ?>">
                                                                    <input type="hidden" name="game_id" value="<?= htmlspecialchars($gameId) ?>">
                                                                    <button type="submit" class="btn btn-danger btn-sm" style="width: 130%;"><i class="fa-solid fa-x"></i></button>
                                                                </div>
                                                            <?php endif; ?>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                        <?php if ($gameHostId === $player['id_utilisateur']): ?>
                                            <div class="border list-host rounded mb-2">
                                                <form method="post" action="remove_player.php">
                                                    <div class="container">
                                                        <div class="row row-list">
                                                            <div class="col-10 pt-2">
                                                                <?= ($player['username']) ?>
                                                            </div>
                                                            <div class="col-2">
                                                                <img src="./Couronne.png" alt="Couronne" style="height: 30px;">
                                                            </div>
                                                        </div>
                                                    </div>
                                                </form>
                                            </div>
                                        <?php endif; ?>
                                    </div>
                                </div>
                            <?php endforeach; ?>

                            <?php if ($gameHostId === $_SESSION['user_id'] && $finished === true): ?>
                                <div class="col-12 d-flex justify-content-center" style="margin-bottom: 20px; margin-top: 100px;">
                                    <button onclick="window.location.href='restart_game.php'" class="rounded-5 fw-bold Shadow-lg bouton-main" style="width: 300px;">Relancer la partie !</button>
                                </div>
                            <?php endif; ?>
                            <?php if ($gameHostId === $_SESSION['user_id']): ?>
                                <!-- Bouton pour retirer un joueur -->
                                <div class="col-12 d-flex justify-content-center" style="margin-bottom: 20px; margin-top: 100px;">
                                    <form method="post" action="delete_a_game.php">
                                        <input type="hidden" name="player_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
                                        <input type="hidden" name="game_id" value="<?= htmlspecialchars($gameId) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Quitter la partie</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                            <?php if ($gameHostId !== $_SESSION['user_id']): ?>
                                <!-- Bouton pour retirer un joueur -->
                                <div class="col-12 d-flex justify-content-center" style="margin-bottom: 20px; margin-top: 100px;">
                                    <form method="post" action="leave_a_game.php">
                                        <input type="hidden" name="player_id" value="<?= htmlspecialchars($_SESSION['user_id']) ?>">
                                        <input type="hidden" name="game_id" value="<?= htmlspecialchars($gameId) ?>">
                                        <button type="submit" class="btn btn-danger btn-sm">Quitter la partie</button>
                                    </form>
                                </div>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>

                <div class="ms-5 col-8 mx-0">
                    <div class="container fond rounded-5 public-tab">
                        <h1 class="text-center text-tab pt-4" style="margin-bottom: 100px;">Classement</h1>
                        <div class="row">
                        <div class="col-2">
                                        <div class="leaderboard-element leaderboard-title">Position</div>
                                    </div>
                                    <div class="col-4">
                                        <div class="leaderboard-element leaderboard-title">Pseudo</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="leaderboard-element leaderboard-title">Avancement</div>
                                    </div>
                                    <div class="col-3">
                                        <div class="leaderboard-element leaderboard-title">Points totaux</div>
                                    </div>
                        </div>
                        <?php foreach ($leaderboardPlayers as $player): ?>
                            <?php
                            $roundId = $db->getRoundIdByUser($player['id_utilisateur']);
                            
                            if ($roundId) {
                                $roundId = $roundId['id_round'];
                                $nombre = $db->getRoundNumberById($roundId);
                                $nombre = $nombre['number'];
                                $nbround = $nombre . "/" . $game['nbRound'];
                            } else {
                                $nbround = "terminé";
                            }

                            ?>
                            <div class="row">
                                <?php if ($postion == 1): ?>
                                    <div class="col-2">
                                        <div class="border leaderboard-element leaderboard-first"><?= $postion ?></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border leaderboard-element leaderboard-first"><?= $player['username'] ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element leaderboard-first"><?= $nbround ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element leaderboard-first"><?= $player['points'] ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($postion == 2): ?>
                                    <div class="col-2">
                                        <div class="border leaderboard-element leaderboard-second"><?= $postion ?></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border leaderboard-element leaderboard-second"><?= $player['username'] ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element leaderboard-second"><?= $nbround ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element leaderboard-second"><?= $player['points'] ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($postion == 3): ?>
                                    <div class="col-2">
                                        <div class="border leaderboard-element leaderboard-third"><?= $postion ?></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border leaderboard-element leaderboard-third"><?= $player['username'] ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element leaderboard-third"><?= $nbround ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element leaderboard-third"><?= $player['points'] ?></div>
                                    </div>
                                <?php endif; ?>
                                <?php if ($postion > 3): ?>
                                    <div class="col-2">
                                        <div class="border leaderboard-element"><?= $postion ?></div>
                                    </div>
                                    <div class="col-4">
                                        <div class="border leaderboard-element"><?= $player['username'] ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element"><?= $nbround ?></div>
                                    </div>
                                    <div class="col-3">
                                        <div class="border leaderboard-element"><?= $player['points'] ?></div>
                                    </div>
                                <?php endif; ?>
                            </div>
                            <?php $postion++ ?>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <footer>
        <!-- place footer here -->
    </footer>

    <!-- Bootstrap JavaScript Libraries -->
    <script src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r" crossorigin="anonymous"></script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+" crossorigin="anonymous"></script>

    <script src="https://kit.fontawesome.com/302501c72f.js" crossorigin="anonymous"></script>
</body>

</html>