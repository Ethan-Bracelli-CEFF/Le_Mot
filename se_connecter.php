<?php
session_start();
require_once('database.php');

$db = new Database();

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $username = $_POST['username'];
    $password = $_POST['password'];

    $user = $db->getUserByCredentials($username, $password);

    if ($user) {
        $_SESSION['user_id'] = $user['id_utilisateur'];
        $_SESSION['username'] = $user['username'];
        header('Location: main.php');
        exit();
    } else {
        echo "<script>alert('Nom d\'utilisateur ou mot de passe incorrect.');</script>";
    }
}
?>

<!doctype html>
<html lang="en">
    <head>
        <title>CheckListED</title>
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
        <link href="./Le_Mot.css" rel="stylesheet" />
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
                        <label for="username" class="form-label">Entrez votre nom d'utilisateur :</label>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <input type="text" name="username" class="form-control input-custom" style="width: 300px;" required>
                    </div>
                </div>
                <div class="row" style="margin-bottom: 300px;">
                    <div class="col-6 d-flex justify-content-end">
                        <label for="password" class="form-label">Entrez votre mot de passe :</label>
                    </div>
                    <div class="col-6 d-flex justify-content-start">
                        <input type="password" name="password" class="form-control input-custom" style="width: 300px;" required>
                    </div>
                </div>
                
                <!-- Boutons -->
                <div class="row">
                    <div class="col-6 d-flex justify-content-center">
                        <a href="accueil.php" class="rounded-5 fw-bold Shadow-lg text-decoration-none bouton-main">Retour</a>
                    </div>
                    <div class="col-6 d-flex justify-content-center">
                        <input class="rounded-5 fw-bold Shadow-lg bouton-main" type="submit" value="Se connecter">
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
            crossorigin="anonymous"
        ></script>

        <script
            src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.min.js"
            integrity="sha384-BBtl+eGJRgqQAUMxJ7pMwbEyER4l1g+O15P+16Ep7Q9Q+zqX6gSbd85u4mG4QzX+"
            crossorigin="anonymous"
        ></script>
    </body>
</html>
