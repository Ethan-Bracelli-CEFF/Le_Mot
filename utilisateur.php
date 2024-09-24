<?php
session_start();
require_once('database.php');

$db = new Database();
$userId = $_SESSION['user_id'];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $newUsername = $_POST['username'];
    $newPassword = $_POST['password'];

    if (isset($_POST['action'])) {
        if ($_POST['action'] === 'update') {
            if ($newUsername !== ""){
                $db->changeUsernameUser($userId, $newUsername);
                $_SESSION['username'] = $newUsername;
            }
            if ($newPassword !== ""){
                $db->changePasswordUser($userId, $newPassword);
            }
        } elseif ($_POST['action'] === 'delete') {
            $db->deleteUser($userId);
            header('Location: accueil.php');
        }
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
            crossorigin="anonymous"
        />
        <link href="/Le_Mot.css" rel="stylesheet" />
    </head>

    <body class="bg-color">
        <header>
            <?php require_once('header.php'); ?>
        </header>
        <main>
            
            <!-- Formulaire de connexion -->
            <form action="utilisateur.php" method="post">
                <div class="container" style="margin-top: 100px;">
                    <div class="row mb-3">
                        <div class="col-6 d-flex justify-content-end">
                            <label for="username" style="color: #FAF0E6; font-size: 23px">Modifiez votre nom d'utilisateur :</label>
                        </div>
                        <div class="col-6 d-flex justify-content-start">
                            <input type="text" name="username" class="form-control" style="width: 300px;" id="username">
                        </div>
                    </div>
                    <div class="row mb-3">
                        <div class="col-6 d-flex justify-content-end">
                            <label for="username" style="color: #FAF0E6; font-size: 23px">Modifiez votre mot de passe :</label>
                        </div>
                        <div class="col-6 d-flex justify-content-start">
                            <input type="password" name="password" class="form-control" style="width: 300px; margin-bottom: 300px" id="password">
                        </div>
                    </div>
                    
                    
                    <!-- Boutons -->
                    <div class="row">
                        <div class="col-3 d-flex justify-content-center">
                            <a href="main.php" class="rounded-5 fw-bold Shadow-lg text-decoration-none bouton-main">Retour</a>
                        </div>
                        <div class="col-3 d-flex justify-content-center">
                            <button class="rounded-5 fw-bold Shadow-lg bouton-main" type="submit" name="action" value="update">Mettre à jour</button>
                        </div>
                        <div class="col-3 d-flex justify-content-center">
                            <a href="accueil.php" class="rounded-5 fw-bold Shadow-lg text-decoration-none bouton-main">Se déconnecter</a>
                        </div>
                        <div class="col-3 d-flex justify-content-center">
                            <button class="rounded-5 fw-bold Shadow-lg bouton-main" style="width: 250px;" type="submit" name="action" value="delete">Supprimer le compte</button>
                        </div>
                    </div>
                    </form>
                </div>
        </main>
        
        <footer>
            <!-- place footer here -->
        </footer>
        
        <!-- Bootstrap JavaScript Libraries -->
        <script
            src="https://cdn.jsdelivr.net/npm/@popperjs/core@2.11.8/dist/umd/popper.min.js"
            integrity="sha384-I7E8VVD/ismYTF4hNIPjVp/Zjvgyol6VFvRkX/vR+Vc4jQkC+hVqc2pM8ODewa9r"
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
