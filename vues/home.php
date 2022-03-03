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
				$showAllPosts = Post::getAllPosts();
				foreach ($showAllPosts as $post) {
					echo '<div class="panel panel-default">';
					echo '<div class="panel-heading"><h4>' . $post->getCommentaire() . '</h4>
					<p><small>Posté le ' . $post->getCreationDate() . '</small></p>
						</div>';
					echo '<div class="panel-body">';
					echo '<p></p>';

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
								echo '<video width="320" height="240" autoplay loop muted controls>
								<source src="upload/' . $media->getNomMedia() .'" type="' . $media->getTypeMedia() .'" />
							  	</video>';
								break;
							case "audio":
								// Audios
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