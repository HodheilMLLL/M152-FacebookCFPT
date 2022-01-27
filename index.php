<?php
session_start();
$uc = filter_input(INPUT_GET, 'uc') == null ? "home" : filter_input(INPUT_GET, 'uc'); // affiche la page accueil par défaut

// afichage du header
include 'vues/header.php';

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