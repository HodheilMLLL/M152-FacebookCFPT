<div class="padding">
	<div class="full col-sm-9">

		<!-- content -->
		<div class="row">

			<!-- main col left -->
			<div class="col-sm-5">

				<div class="panel panel-default">
					<div class="panel-thumbnail"><img src="assets/img/bg_5.jpg" class="img-responsive"></div>
					<div class="panel-body">
						<p class="lead">The Big Dodos</p>
						<p>4,6M Followers, <?= Post::countAllPosts() ?> Posts</p>
					</div>
				</div>
			</div>

			<!-- main col right -->
			<div class="col-sm-7">
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

				$showAllPosts = Post::getAllPosts();
				foreach ($showAllPosts as $post) {
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading"><h4>' . $post->getCommentaire() . '</h4>
					<span style="float: right;">					
					<a href="index.php?uc=post&action=update&idPost=' . $post->getIdPost() . '"><button type="button" class="btn btn-success" id="' . $post->getIdPost() . '"><i class="fa fa-pencil"></i></button></a>
					<button type="button" class="btn btn-danger" id="' . $post->getIdPost() . '" data-toggle="modal" data-target="#ModalSuppression" data-whatever="@mdo" onClick="ChangeModalLink(' . $post->getIdPost() . ')"><i class="fa fa-trash"></i></button>
					</span>';
					if ($post->getCreationDate() == $post->getModificationDate()) {
						echo '<p><small>Posté le ' . $post->getCreationDate() . '</small></p>
						</div>';
					} else {
						echo '<p><small>Posté le ' . $post->getCreationDate() . ' (Modifié le : ' .$post->getModificationDate() . ')</small></p>
						</div>';
					}
					
					echo '<div class="panel-body">';					

					$showMediaByPostId = Media::getMediaByPostId($post->getIdPost());
					$countMedia = 0;
					echo '<div class="media">';
					foreach ($showMediaByPostId as $media) {
						// Faire un switch en fonction de son type
						switch (explode('/', $media->getTypeMedia())[0]) {
							case "image":
								// Images
								echo '<img class="media-object pull-left" src="upload/' . $media->getNomMedia() . '" width="300"/>';
								break;
							case "video":
								// Vidéos
								echo '<video class="media-object pull-left" width="320" height="240" autoplay loop muted controls>
								<source src="upload/' . $media->getNomMedia() . '" type="' . $media->getTypeMedia() . '" />
							  	</video>';
								break;
							case "audio":
								// Audios
								echo '<audio class="media-object pull-left" controls>
								<source src="upload/' . $media->getNomMedia() . '" type="' . $media->getTypeMedia() . '">
							  	</audio>';
								break;
						}

						$countMedia++;
					}
					echo '</div></div></div>';
				}
				?>


			</div>
		</div>
		<div class="row" id="footer">
			<div class="col-sm-6">

			</div>
			<div class="col-sm-6">
				<p>
					<a href="#" class="pull-right">© Copyright 2022</a>
				</p>
			</div>
		</div>
	</div><!-- /col-9 -->
</div><!-- /padding -->
</div>
<!-- /main -->

</div>
</div>
</div>
<!-- Modale de suppression de post -->
<div class="modal fade" id="ModalSuppression" tabindex="-1" role="dialog" aria-labelledby="ModalSuppression" aria-hidden="true">
	<div class="modal-dialog" role="document">
		<div class="modal-content">
			<div class="modal-header">
				<button type="button" class="close" data-dismiss="modal" aria-label="Close">
					<span aria-hidden="true">&times;</span>
				</button>
				<h4 class="modal-title" id="ModalSuppression">Confirmation</h4>
			</div>
			<div class="modal-body">
				Êtes-vous sur de vouloir supprimer cet élément ?
			</div>
			<div class="modal-footer">
				<button type="button" class="btn btn-secondary" data-dismiss="modal">Annuler</button>
				<a id="btnDelete" class="btn btn-danger" href="#">Supprimer</a>
			</div>
		</div>
	</div>
</div>
<!-- Fin modale de suppression de post -->
<script type="text/javascript">
	// Modifie le lien du bouton suppression de la modal
	function ChangeModalLink(idPost) {
		document.getElementById('btnDelete').href = "index.php?uc=post&action=delete&idPost=" + idPost;
	}
</script>