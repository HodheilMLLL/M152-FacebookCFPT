<div class="well" id="newPost">
<?php
    // message de confirmation
    if ($_SESSION['messageAlert']['type'] != null) {
    ?>
        <div class="alert alert-<?= $_SESSION['messageAlert']['type'] ?>">
        <?= $_SESSION['messageAlert']['message'] ?>
        </div>
    <?php
        $_SESSION['messageAlert']['type'] = null;
        $_SESSION['messageAlert']['message'] = null;
    }
    ?>
    <?php
    $idPost = filter_input(INPUT_GET, 'idPost');

    $post = Post::getPostById($idPost);
    ?>
    <form class="form-horizontal" role="form" action="index.php?uc=post&action=confirmUpdate&idPost=<?= $idPost ?>" method="POST" enctype="multipart/form-data">
        <h4>Modifier votre post</h4>
        <div class="form-group" style="padding:14px;">
            <textarea id="postTextArea" class="form-control" style="height: 10rem;" placeholder="Entrez le contenu du post" name="commentaire"><?= $post->getCommentaire(); ?></textarea>
            <h5 style="padding-top: 2rem;">Image(s)</h5>            
        <input type="file" name="myImg[]" accept="image/*, video/*, audio/*" multiple>
        </div>
        <input class="btn btn-primary right-block" style="width: 50%;" type="submit" value="Modifier"/>
        
    </form>
    
</div>