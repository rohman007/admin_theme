<div class="column is-6 show grid2">
	<a href="<?php echo get_permalink('game', $game->slug) ?>">
		<div class="g-card-2">
			<div class="pic">
				<figure class="ratio ratio-1">
					<img src="<?php echo get_small_thumb($game) ?>" class="small-thumb" alt="<?php echo esc_string($game->title) ?>">
				</figure>
			</div>
			<div class="g-info">
				<h3 class="grid-title ellipsis"><?php echo esc_string($game->title); ?></h3>
				<div class="rating ellipsis">
					<span class="ico ico-star"></span> <?php echo get_rating('5-decimal', $game) ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
				</div>
				<a href="<?php echo get_permalink('game', $game->slug) ?>" class="bt-play"><img src="<?php echo get_template_path(); ?>/images/icon/play.svg" alt=""></a>
			</div>
		</div>
	</a>
</div>