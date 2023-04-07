<div class="col-md-6 grid-2">
	<a href="<?php echo get_permalink('game', $game->slug) ?>">
	<div class="game-item">
		<div class="list-game yml">
			<div class="list-thumbnail yml">
				<img src="<?php echo get_small_thumb($game) ?>" class="small-thumb" alt="<?php echo esc_string($game->title) ?>">
			</div>
			<div class="list-info yml">
				<div class="list-info-child yml">
					<div class="list-title ellipsis"><?php echo esc_string($game->title) ?></div>
					<span class="list-rating ellipsis">
						<i class="bi bi-star-fill star-on"></i>
						<?php echo get_rating('5-decimal', $game) ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
					</span>
				</div>
				<div class="list-b-play"><img src="<?php echo get_template_path(); ?>/images/icon/play.svg" alt=""></div>
			</div>
		</div>
	</div>
	</a>
</div>