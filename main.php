<?php session_start();
require_once('database.php');
$db = new Database();

if (isset($_SESSION['kicked'])) {
    echo '<div class="alert alert-danger" role="alert">' . $_SESSION['kicked'] . '</div>';
    // Supprime le message après l'affichage
    unset($_SESSION['kicked']);
}

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['code']) && isset($_POST['password'])) {
    $code = $_POST['code'];
    $password = $_POST['password'];
    $game = $db->getPrivateGameByCode($code);
    if (isset($game) && $game !== false) {
        if ($password === $game['password']) {
            if($game['started'] === 0){
                $_SESSION['game'] = $game;
                $db->updatePlayerGame($_SESSION['user_id'], $game['id_game']);
                header('Location: waiting_room.php');
            } else {
                echo "<script>alert('Cette partie a déjà commencé !');</script>";
            }
        } else {
            echo "<script>alert('Le mot de passe est incorrect.');</script>";
        }
    } else {
        echo "<script>alert('La partie que vous essayez de joindre n'éxiste pas.');</script>";
    }
}

$publicGames = $db->getPublicGames();
?>
<!doctype html>
<html lang="en">

<head>
    <title>Le Mot</title>
    <!-- Required meta tags -->
    <meta charset="utf-8" />
    <meta
        name="viewport"
        content="width=device-width, initial-scale=1, shrink-to-fit=no" />

    <!-- Bootstrap CSS v5.2.1 -->
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link href="/Le_Mot.css" rel="stylesheet" />
</head>

<body class="bg-color">
    <header>
        <?php require_once('header.php'); ?>
    </header>
    <main>
        <div class="container-fluid">
            <div class="row mt-5">
                <div class="ms-5 col-3 mx-0">
                    <div class="container fond rounded-5 priv-tab">
                        <div class="row">
                            <h1 class="text-center text-tab" style="margin-bottom: 100px;">Parties Privées</h1>
                            <form action="" method="post">
                                <div class="d-flex" style="margin-bottom: 100px;">
                                    <div class="col-6 d-flex justify-content-end me-2">
                                        <label for="code" class="form-label">Code Secret :</label>
                                    </div>
                                    <div class="col-6">
                                        <input type="text" name="code" class="form-control input-custom" style="width: 200px;" required>
                                    </div>
                                </div>
                                <div class="d-flex" style="margin-bottom: 100px;">
                                    <div class="col-6 d-flex justify-content-end me-2">
                                        <label for="password" class="form-label">Mot de Passe :</label>
                                    </div>
                                    <div class="col-6 d-flex justify-content-start">
                                        <input type="text" name="password" class="form-control input-custom" style="width: 200px;" required>
                                    </div>
                                </div>
                                <div class="col-12 d-flex justify-content-center" style="margin-bottom: 100px;">
                                    <input type="hidden" name="rej_priv" id="rej_priv">
                                    <input class="rounded-5 fw-bold Shadow-lg bouton-main" type="submit" value="Rejoindre la partie privé" style="width: 300px;">
                                </div>
                            </form>
                            <div class="col-12 d-flex justify-content-center" style="margin-bottom: 20px;">
                                <button onclick="window.location.href='creer_partie_priv.php'" class="rounded-5 fw-bold Shadow-lg bouton-main" style="width: 300px;">Creer une Partie Privée</button>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="ms-5 col-8 mx-0">
                    <div class="container fond rounded-5 public-tab">
                        <div class="row">
                            <h1 class="text-center text-tab">Parties Publiques</h1>
                            <?php
                            if (count($publicGames) > 0) {
                                foreach ($publicGames as $game) { ?>
                                    <?php

                                    $gameHost = $db->getUser($game['hostId']);
                                    if ($game['difficulty'] === "easy") {
                                        $difficulte = "Facile";
                                    } elseif ($game['difficulty'] === "normal") {
                                        $difficulte = "Moyen";
                                    } elseif ($game['difficulty'] === "hard") {
                                        $difficulte = "Difficile";
                                    }

                                    ?>
                                    <div class="col-3 m-3">
                                        <div class="card">
                                            <div class="card-body">
                                                <h5 class="card-title"><?= htmlspecialchars($game["name"]) ?></h5>
                                                <p class="card-text">Hôte : <?= htmlspecialchars($gameHost["username"]) ?></p>
                                                <p class="card-text">Difficulté : <?= htmlspecialchars($difficulte) ?></p>

                                                <!-- Conteneur flex pour les deux boutons -->
                                                <div class="d-flex justify-content-between">
                                                    <form action="join_game.php" method="post">
                                                        <input type="hidden" name="id_game" value=<?= htmlspecialchars($game["id_game"]) ?>>
                                                        <button class="btn btn-success" style="height: 40px;" type="submit">Rejoindre</button>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                            <?php
                                }
                            } else {
                                echo "<p>Aucune partie trouvée.</p>";
                            }
                            ?>
                            <div class="col-12 d-flex justify-content-center" style="margin-bottom: 20px;">
                                <button onclick="window.location.href='creer_partie_public.php'" class="rounded-5 fw-bold Shadow-lg bouton-main" style="width: 300px;">Creer une Partie Public</button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
    <footer>
        <!-- place footer here -->
    </footer>
    <!-- Bootstrap JavaScript Libraries -->
    <script
        src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
        integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
        crossorigin="anonymous"></script>

    <script
        src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
        integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
        crossorigin="anonymous"></script>
</body>

</html>