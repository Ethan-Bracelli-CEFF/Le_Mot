<div class="container-fluid">
    <div class="row row-header">
        <div class="col-6 mt-3 mx-3">
            <h1 class="fw-bold text-start MOT-titre">Le Mot</h1>
        </div>

        <div class="col mt-3 mx-3">
            <a href="/utilisateur.php" class="text-decoration-none">
                <h1 class="fw-bold text-end big-username"><?php echo ($_SESSION['username']); ?></h1>
            </a>
        </div>
        <div class="col-1 d-flex justify-content-end  mt-3">
            <a href="/accueil.php"><img src="/log-out-icon.png" class="rounded-5" style="width: 120px; height: 120px"></a>
        </div>
    </div>
</div>