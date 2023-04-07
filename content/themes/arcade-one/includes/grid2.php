<div class="column is-3-desktop is-6-mobile show">
	<div class="g-card">
		<div class="pic">
			<figure class="ratio ratio-75">
				<a href="<?php echo get_permalink('game', $game->slug) ?>">
					<img src="<?php echo $game->thumb_1 ?>" class="game-thumb" alt="<?php echo esc_string($game->title) ?>">
				</a>
			</figure>
		</div>
		<div class="g-info">
			<h3 class="grid-title ellipsis"><?php echo esc_string($game->title); ?></h3>
			<div class="rating ellipsis">
				<span class="ico ico-star"></span> <?php echo get_rating('5-decimal', $game) ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
			</div>
			<div class="bt-cta">
				<a class="cta" href="<?php echo get_permalink('game', $game->slug) ?>"><?php _e('Play Now') ?></a>
			</div>
		</div>
	</div>
</div>