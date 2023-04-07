<div class="column is-2-widescreen is-3-desktop is-4-tablet is-6-mobile show">
	<div class="g-card">
		<div class="pic">
			<figure class="ratio ratio-1">
				<a href="<?php echo get_permalink('game', $game->slug) ?>">
					<img src="<?php echo get_small_thumb($game) ?>" class="small-thumb" alt="<?php echo esc_string($game->title) ?>">
				</a>
			</figure>
		</div>
		<div class="g-info">
			<h3 class="grid-title ellipsis">
				<a href="<?php echo get_permalink('game', $game->slug) ?>"><?php echo esc_string($game->title); ?></a>
			</h3>
			<div class="info">
				<div class="rating ellipsis">
					<span class="ico ico-star"></span> <?php echo get_rating('5-decimal', $game) ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
				</div>
			</div>
			<a href="<?php echo get_permalink('game', $game->slug) ?>" class="bt-play"><img src="<?php echo get_template_path(); ?>/images/icon/play.svg" alt=""></a>
		</div>
	</div>
</div>