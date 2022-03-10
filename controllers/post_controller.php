<?php
// Variables
$action = filter_input(INPUT_GET, 'action');
$dossier = 'upload';
$taille_maxi = 3000000; // 3Mo en octets
$taille_tout = 0; // Taille de tous les fichiers que l'utilisteur veut uploader
$taille_maxi_tout = 70000000; // 70Mo en octets
$extensions = array('.png', '.gif', '.jpg', '.jpeg', '.mp4', '.mov', '.wmv', '.avi', '.mkv', '.webm', '.m4a', '.flac', '.mp3', '.wav', '.wma', '.aac');
$createdFiles = array();

switch ($action) {
    case 'show':
        include 'vues/post.php';
        break;
    case 'post':
        // Lancement de la transaction
        MonPdo::getInstance()->beginTransaction();
        try {

            $commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

            $post = new Post();
            $post->setCommentaire($commentaire);
            $idPost = Post::addPost($post);

            unset($erreur);

            $countfiles = count($_FILES['myImg']['name']);

            for ($i = 0; $i < $countfiles; $i++) {
                $fichier = $_FILES['myImg']['name'][$i];
                $taille = filesize($_FILES['myImg']['tmp_name'][$i]);
                $taille_tout += $taille;

                $extension = strrchr($fichier, '.');

                if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                {
                    $erreur = 'Vous devez uploader un fichier de type png, gif, jpg ou jpeg';
                    // Annulation de la transaction
                    throw new Exception;
                }
                if ($taille > $taille_maxi) {
                    $erreur = "Taille de fichier(s) dépassant la limite";
                    // Annulation de la transaction
                    throw new Exception;
                }

                if (!isset($erreur)) // S'il n'y a pas d'erreur, on upload
                {
                    $temp = explode(".", $_FILES["myImg"]["name"][$i]);
                    $newfilename = round(microtime(true)) . $i . '.' . end($temp);
                    if (move_uploaded_file($_FILES['myImg']['tmp_name'][$i], "$dossier/" . $newfilename)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    {
                        // Ajout du fichier dans le tableau des fichiers créés
                        array_push($createdFiles, $newfilename);

                        // Insertion dans la base de données
                        $media = new Media();
                        $media->setTypeMedia($_FILES["myImg"]["type"][$i]);
                        $media->setNomMedia($newfilename);
                        Media::addMedia($media, $idPost);
                    } else //Sinon (la fonction renvoie FALSE).
                    {
                        // Annulation de la transaction
                        throw new Exception;
                    }
                }
            }
            // Vérification du non-dépassement de la limite de 70Mo
            if ($taille_tout > $taille_maxi_tout) {
                // Annulation de la transasction
                $erreur = "Fichier(s) trop lourd(s)";
                throw new Exception;
            }
        } catch (\Throwable $th) {
            // Si une erreur est rencontrée, annulation de la transaction
            MonPdo::getInstance()->rollBack();
        }

        try {
            // Validation de la transaction
            MonPdo::getInstance()->commit();
        } catch (\Throwable $th) {
            // Affichage d'un message d'erreur
            $_SESSION['messageAlert']['type'] = "danger";
            $_SESSION['messageAlert']['message'] = $erreur;

            // Suppression des fichiers qui ont été crées
            foreach ($createdFiles as $file) {
                unlink("$dossier/" . $file);
            }
        }

        if (!isset($erreur)) // S'il aucune erreur n'a été rencontrée
        {
            // Affichage d'un message de succès
            $_SESSION['messageAlert']['type'] = "success";
            $_SESSION['messageAlert']['message'] = "Votre post a été crée avec succès";
        }
        include 'vues/post.php';
        break;
    case 'delete': // Suppression d'un post
        // Récupère l'id du post à supprimer
        $idPost = filter_input(INPUT_GET, 'idPost');

        // Lancement de la transaction
        MonPdo::getInstance()->beginTransaction();

        try {
            // Récupère touts les medias en lien avec ce post
            $allMedias = Media::getMediaByPostId($idPost);

            // Suppression du post (cela supprimera aussi les medias côté bd car les medias sont ON DELETE CASCADE)
            Post::deletePostById($idPost);

            // Suppression des medias dans le dossier upload
            foreach ($allMedias as $media) {
                unlink("$dossier/" . $media->getNomMedia());
            }
        } catch (\Throwable $th) {
            // Si une erreur est rencontrée, annulation de la transaction
            MonPdo::getInstance()->rollBack();
        }

        try {
            // Validation de la transaction
            MonPdo::getInstance()->commit();
        } catch (\Throwable $th) {
            // Affichage d'un message d'erreur
            $_SESSION['messageAlert']['type'] = "danger";
            $_SESSION['messageAlert']['message'] = "Erreur lors de la suppression du post";
        }

        include 'vues/home.php';
        break;
    case 'update': // Affichage de la page de modification
        include 'vues/update.php';
        break;
    case 'confirmUpdate': // Modification d'un post
        $idPost = filter_input(INPUT_GET, 'idPost');
        $commentaire = filter_input(INPUT_POST, 'commentaire', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

        // Lancement de la transaction
        MonPdo::getInstance()->beginTransaction();

        try {
            // Récupère touts les medias en lien avec ce post
            $allMedias = Media::getMediaByPostId($idPost);

            // Modifie le post
            Post::updatePostById($idPost, $commentaire);

            // Suppression des medias dans le dossier upload ainsi que dans la base de données
            foreach ($allMedias as $media) {
                unlink("$dossier/" . $media->getNomMedia());

                Media::deleteMediaByPostId($media->getPost_id());
            }
            // Insertion des nouvaux medias
            unset($erreur);

            $countfiles = count($_FILES['myImg']['name']);

            for ($i = 0; $i < $countfiles; $i++) {
                $fichier = $_FILES['myImg']['name'][$i];
                $taille = filesize($_FILES['myImg']['tmp_name'][$i]);
                $taille_tout += $taille;

                $extension = strrchr($fichier, '.');

                if (!in_array($extension, $extensions)) //Si l'extension n'est pas dans le tableau
                {
                    $erreur = 'Vous devez uploader un fichier de type png, gif, jpg ou jpeg';
                    // Annulation de la transaction
                    throw new Exception;
                }
                if ($taille > $taille_maxi) {
                    $erreur = "Taille de fichier(s) dépassant la limite";
                    // Annulation de la transaction
                    throw new Exception;
                }

                if (!isset($erreur)) // S'il n'y a pas d'erreur, on upload
                {
                    $temp = explode(".", $_FILES["myImg"]["name"][$i]);
                    $newfilename = round(microtime(true)) . $i . '.' . end($temp);
                    if (move_uploaded_file($_FILES['myImg']['tmp_name'][$i], "$dossier/" . $newfilename)) //Si la fonction renvoie TRUE, c'est que ça a fonctionné...
                    {
                        // Ajout du fichier dans le tableau des fichiers créés
                        array_push($createdFiles, $newfilename);

                        // Insertion dans la base de données
                        $media = new Media();
                        $media->setTypeMedia($_FILES["myImg"]["type"][$i]);
                        $media->setNomMedia($newfilename);
                        Media::addMedia($media, $idPost);
                    } else //Sinon (la fonction renvoie FALSE).
                    {
                        // Annulation de la transaction
                        throw new Exception;
                    }
                }
            }
            // Vérification du non-dépassement de la limite de 70Mo
            if ($taille_tout > $taille_maxi_tout) {
                // Annulation de la transasction
                $erreur = "Fichier(s) trop lourd(s)";
                throw new Exception;
            }
        } catch (\Throwable $th) {
            // Si une erreur est rencontrée, annulation de la transaction
            MonPdo::getInstance()->rollBack();
        }

        try {
            // Validation de la transaction
            MonPdo::getInstance()->commit();
        } catch (\Throwable $th) {
            // Affichage d'un message d'erreur
            $_SESSION['messageAlert']['type'] = "danger";
            $_SESSION['messageAlert']['message'] = $erreur;

            // Suppression des fichiers qui ont été crées
            foreach ($createdFiles as $file) {
                unlink("$dossier/" . $file);
            }
        }

        if (!isset($erreur)) // S'il aucune erreur n'a été rencontrée
        {
            // Affichage d'un message de succès
            $_SESSION['messageAlert']['type'] = "success";
            $_SESSION['messageAlert']['message'] = "Votre post a été modifié avec succès";
        }
        include 'vues/update.php';
        break;
}
