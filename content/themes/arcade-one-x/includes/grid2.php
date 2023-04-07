<div class="col-xl-3 col-lg-4 col-md-4 col-6 grid-2">
	<a href="<?php echo get_permalink('game', $game->slug) ?>">
	<div class="game-item">
		<div class="list-game">
			<div class="list-thumbnail">
				<img src="<?php echo DOMAIN . $game->thumb_1 ?>" alt="<?php echo esc_string($game->title) ?>">
			</div>
			<div class="list-info">
				<div class="list-title ellipsis"><?php echo esc_string($game->title) ?></div>
				<span class="list-rating ellipsis">
					<i class="bi bi-star-fill star-on"></i>
					<?php echo get_rating('5-decimal', $game) ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
				</span>
				<div class="btn btn-capsule btn-wide"><?php _e('Play Now') ?></div>
			</div>
		</div>
	</div>
	</a>
</div>