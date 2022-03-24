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
            <?php 
              echo '<div class="panel-body">';					

              $showMediaByPostId = Media::getMediaByPostId($post->getIdPost());
              $countMedia = 0;

              foreach ($showMediaByPostId as $media) {
                  echo '<div>';
                  // Faire un switch en fonction de son type
                  switch (explode('/', $media->getTypeMedia())[0]) {
                      case "image":
                          // Images
                          echo '<img src="upload/' . $media->getNomMedia() . '" width="200"/>';
                          break;
                      case "video":
                          // Vidéos
                          echo '<video class="media-object pull-left" width="200" loop muted controls>
                          <source src="upload/' . $media->getNomMedia() . '" type="' . $media->getTypeMedia() . '" />
                            </video>';
                          break;
                      case "audio":
                          // Audios
                          echo '<audio  style="width : 200px;" controls>
                          <source src="upload/' . $media->getNomMedia() . '" type="' . $media->getTypeMedia() . '"/>
                            </audio>';
                          break;
                  }
                  echo '<a href="index.php?uc=post&action=deleteMedia&idMedia=' . $media->getIdMedia() . '&idPost=' . $post->getIdPost() . '&nomMedia=' . $media->getNomMedia() . '"><button type="button" class="btn btn-danger" id="' . $media->getIdMedia() . '"><i class="fa fa-trash"></i></button></a>';
                  echo '</div><br/>';
                  $countMedia++;
              }
              
              echo '</div>';  
            ?>
            <h5 style="padding-top: 2rem;">Nouvelle(s) image(s)</h5>            
        <input type="file" name="myImg[]" accept="image/*, video/*, audio/*" multiple>
        </div>
        <input class="btn btn-primary right-block" style="width: 50%;" type="submit" value="Modifier"/>
        
    </form>
    
</div>