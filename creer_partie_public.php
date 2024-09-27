<?php
session_start();
require_once('database.php');

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $name = $_POST['name'];
    $difficulty = $_POST['difficulty'];
    $host = $_SESSION['user_id'];
    $nbRound =  intval($_POST['nbRound']);


    if (isset($name) && isset($difficulty) && isset($host)) {
        $db = new Database();
        $db->createPublicGame($name, $host, $difficulty, $nbRound);
        $game = $db->getPublicGameByHost($host);
        $_SESSION['game'] = $game;
        $db->updatePlayerGame($_SESSION['user_id'], $game['id_game']);

        header("Location: waiting_room.php");
        exit();
    }
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
    <link
        href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css"
        rel="stylesheet"
        integrity="sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN"
        crossorigin="anonymous" />
    <link href="/Le_Mot.css" rel="stylesheet" />
</head>

<body class="bg-color">
    <header>
        <!-- place navbar here -->
    </header>
    <main>
        <h1 class="fw-bold text-center big-MOT">Le Mot</h1>

        <!-- Formulaire de connexion -->
        <form action="" method="post">
            <div class="container" style="margin-top: 100px;">
                <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-end">
                        <label for="name" class="form-label">Entrez le nom de la partie :</label>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <input type="text" name="name" class="form-control input-custom" style="width: 300px;" required>
                    </div>
                </div>
                <div class="row mb-3">
                    <div class="col-6 d-flex justify-content-end">
                        <label for="nbRound" class="form-label">Entrez le nombre de round :</label>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <input type="number" name="nbRound" class="form-control input-custom" style="width: 300px;" required min="1">
                    </div>
                </div>
                <div class="row" style="margin-bottom: 100px;">
                    <div class="col-6 d-flex justify-content-end">
                        <label for="difficulty" class="form-label">Choisissez la difficulté :</label>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <select name="difficulty" class="form-select" require>
                            <option value="easy">Facile</option>
                            <option value="normal">Moyen</option>
                            <option value="hard">Difficile</option>
                        </select>
                    </div>
                </div>


                <!-- Boutons -->
                <div class="row">
                    <div class="col-6 d-flex justify-content-center">
                        <a href="main.php" class="btn rounded-5 fw-bold Shadow-lg text-decoration-none bouton-main" style="display: flex; align-items: center; justify-content: center;">Retour</a>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <input class="rounded-5 fw-bold Shadow-lg bouton-main" type="submit" value="Créer la partie public" style="width: 250px;">
                    </div>
                </div>
            </div>
        </form>
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