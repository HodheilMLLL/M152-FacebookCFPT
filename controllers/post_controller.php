<?php
$action = filter_input(INPUT_GET, 'action');
switch ($action) {
    case 'show':
        include 'vues/post.php';
        break;
    case 'post':
        $commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_STRING);

        $post = new Post();
        $post->setCommentaire($commentaire);
        Post::addPost($post);

        $dossier = 'upload';
        $taille_maxi = 3000000; // 3Mo en octets
        $extensions = array('.png', '.gif', '.jpg', '.jpeg');
        $countfiles = count($_FILES['myImg']['name']);

        echo "<pre>";
        var_dump($_FILES);
        echo "</pre>";

        for ($i = 0; $i < $countfiles; $i++) {
            $fichier = $_FILES['myImg']['name'][$i];
            $taille = filesize($_FILES['myImg']['tmp_name'][$i]);
            unset($erreur);

            $extension = strrchr($fichier, '.');

            if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
            {
                $erreur = 'Vous devez uploader un fichier de type png, gif, jpg ou jpeg';
            }
            if ($taille > $taille_maxi) {
                $erreur = 'Le fichier est trop gros...';
            }

            if (!isset($erreur)) //S'il n'y a pas d'erreur, on upload
            {
                $temp = explode(".", $_FILES["myImg"]["name"][$i]);
                $newfilename = round(microtime(true)) . $i . '.' . end($temp);
                if (move_uploaded_file($_FILES['myImg']['tmp_name'][$i], "$dossier/" . $newfilename)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                {
                    echo 'Upload effectué avec succès !';
                    // Insertion dans la base de données

                } else //Sinon (la fonction renvoie FALSE).
                {
                    echo 'Echec de l\'upload !';
                }
            } else {
                echo $erreur;
            }
        }
        break;
}