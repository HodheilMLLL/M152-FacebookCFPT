<?php
session_start();
$uc = filter_input(INPUT_GET, 'uc') == null ? "home" : filter_input(INPUT_GET, 'uc'); // affiche la page accueil par défaut

$_SESSION['messageAlert']['type'] = null;
$_SESSION['messageAlert']['message'] = null;

ini_set('display_errors', 1);


include 'models/PDO.php';
include 'models/Post.php';
include 'models/Media.php';

// afichage du header
if ($uc != 'countPosts') {
    include 'vues/header.php';
}


// Gestion des affichages
switch ($uc) {
    case 'home': // Affichage de la page d'accueil
        include 'vues/home.php';
        break;
    case 'post': // Affichage de la page de post
        include 'controllers/post_controller.php';
        break;
    case 'countPosts': // Récupère les posts
        echo json_encode(Post::countAllPosts());
        break;
}

// afichage du footer
if ($uc != 'countPosts') {
    include 'vues/footer.php';
}

error_reporting(E_ALL);
