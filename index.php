<?php
require_once "src/Bdd/Bdd.php";
session_start();
$isLoggedIn = isset($_SESSION['user']);
?>
<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    <meta name="description" content="" />
    <meta name="author" content="" />
    <title>Mon Site</title>
    <link rel="icon" type="image/x-icon" href="assets/favicon.ico" />
    <link href="assets/css/styles.css" rel="stylesheet" />
</head>
<body>
<div class="d-flex" id="wrapper">
    <div class="border-end bg-white" id="sidebar-wrapper">
        <div class="sidebar-heading border-bottom bg-light">Mon Site</div>
        <div class="list-group list-group-flush">
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="index.php">Accueil</a>
            <?php if($isLoggedIn): ?>
            <a class="list-group-item list-group-item-action list-group-item-light p-3" href="src/traitement/traitProfil.php">Profil</a>
            <?php endif; ?>
        </div>
    </div>
    <!-- Page content wrapper-->
    <div id="page-content-wrapper">
        <!-- Top navigation-->
        <nav class="navbar navbar-expand-lg navbar-light bg-light border-bottom">
            <div class="container-fluid">
                <button class="btn btn-primary" id="sidebarToggle">Menu</button>
                <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation"><span class="navbar-toggler-icon"></span></button>
                <div class="collapse navbar-collapse" id="navbarSupportedContent">
                    <ul class="navbar-nav ms-auto mt-2 mt-lg-0">
                        <li class="nav-item"><a class="nav-link" href="index.php">Accueil</a></li>
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" id="navbarDropdown" href="#" role="button" data-bs-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                <?= $isLoggedIn ? $_SESSION['user'] : 'Compte' ?>
                            </a>
                            <div class="dropdown-menu dropdown-menu-end" aria-labelledby="navbarDropdown">
                                <?php if(!$isLoggedIn): ?>
                                <a class="dropdown-item" href="src/traitement/traitConnexion.php">Connexion</a>
                                <a class="dropdown-item" href="vue/inscription.php">Inscription</a>
                                <a class="dropdown-item" href="src/traitement/traitProfil.php">Profil</a>
                                <div class="dropdown-divider"></div>
                                <a class="dropdown-item" href="src/traitement/deconnexion.php">Déconnexion</a>
                                <?php endif; ?>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </nav>
        <!-- Page content-->
        <div class="container-fluid">
            <h1 class="mt-4">Bienvenue</h1>
            <?php if($isLoggedIn): ?>
            <p>Bonjour <?= htmlspecialchars($_SESSION['user']) ?>, vous êtes connecté.</p>
            <?php else: ?>
            <p>Veuillez vous connecter ou vous inscrire pour accéder à toutes les fonctionnalités.</p>
            <?php endif; ?>
        </div>
    </div>
</div>
<!-- Bootstrap core JS-->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.2.3/dist/js/bootstrap.bundle.min.js"></script>
<!-- Core theme JS-->
<script src="assets/js/scripts.js"></script>
</body>
</html>