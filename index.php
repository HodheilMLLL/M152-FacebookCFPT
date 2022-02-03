<?php
session_start();
$uc = filter_input(INPUT_GET, 'uc') == null ? "home" : filter_input(INPUT_GET, 'uc'); // affiche la page accueil par défaut

ini_set('display_errors', 1);
// afichage du header
include 'vues/header.php';

include 'models/PDO.php';
include 'models/AllPosts.php';
include 'models/AllMedias.php';

// Gestion des affichages
switch ($uc) {
        // Affichage de la page d'accueil
    case 'home':
        include 'vues/home.php'; // affiche la vue d'accueil
        break;
    case 'post':
        include 'controllers/post_controller.php';
        break;
}

// afichage du footer
include 'vues/footer.php';

error_reporting(E_ALL);