<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<?php widget_aside('top-content') ?>

<section class="mid-ct section-game">
	<div class="container">
		<div class="columns">
			<div class="column is-12-tablet is-9-desktop">
				<div class="article game-container">
					<div class="game-iframe-container">
						<iframe class="game-iframe" id="game-area" src="<?php echo get_game_url($game); ?>" width="<?php echo esc_int($game->width); ?>" height="<?php echo esc_int($game->height); ?>" scrolling="none" frameborder="0" allowfullscreen></iframe>
					</div>
					<div class="article-header">
						<div class="text">
							<h1><?php echo htmlspecialchars( $game->title )?></h1>
							<div class="meta-info"><?php _e('Played %a times.', esc_int($game->views)) ?></div>
							<div class="rating">
								<?php
								$rating = get_rating('5-decimal', $game);

								for ($i=0; $i < 5; $i++) { 
									if($i < $rating){
										echo '<span class="ico ico-star"></span>';
									} else {
										echo '<span class="ico ico-star-off"></span>';
									}
								}
								?>
								<?php echo $rating ?> (<?php echo $game->upvote+$game->downvote ?> <?php _e('Reviews') ?>)
							</div>
							<div class="bt-group">
								<a href="#" class="bt" id="upvote" data-id="<?php echo $game->id ?>"><span class="icon-thumbs-up"></span></a>
								<a href="#" class="bt" id="downvote" data-id="<?php echo $game->id ?>"><span class="icon-thumbs-down"></span></i></a>
								<a href="https://www.facebook.com/sharer/sharer.php?u=<?php echo htmlspecialchars(get_cur_url()); ?>" target="_blank" class="bt-share"><img src="<?php echo get_template_path() . '/images/facebook.png' ?>" alt="share" width="40" height="40" class="social-icon"></a>
								<a href="https://twitter.com/intent/tweet?url=<?php echo htmlspecialchars(get_cur_url()); ?>" target="_blank" class="bt-share"><img src="<?php echo get_template_path() . '/images/twitter.png' ?>" alt="share" width="40" height="40" class="social-icon"></a>
								<?php
								if(defined('GAME_REPORTS')){
									?><a href="#" class="bt-round" id="report-game"><?php _e('Report') ?></a>
									<?php
								}
								?>
							</div>
						</div>
						<div class="bt-group-2">
							<a href="<?php echo get_permalink('full', $game->slug); ?>" target="_blank"><span class="icon-new-tab"></span> <?php _e('Open in new window') ?></a>
							<a href="#" onclick="open_fullscreen()"><span class="icon-fullscreen"></span> <?php _e('Fullscreen') ?></a>
						</div>
					</div>
					<div class="article-ct">
						<h3><?php _e( 'Description' )?></h3>
						<p class="game-description"><?php echo nl2br( $game->description )?></p>
						<h3><?php _e( 'Instructions' )?></h3>
						<p class="game-instructions"><?php echo nl2br( $game->instructions )?></p>
						<?php if($game->source == 'self'){ ?>
							<div class="single-leaderboard">
								<div id="content-leaderboard" class="table-responsive" data-id="<?php echo $game->id ?>"></div>
							</div>
						<?php } ?>
						<h3><?php _e( 'Categories' )?></h3>
						<p class="game-category-list"> 
							<?php if ( $game->category ) {
								$categories = commas_to_array($game->category);
								foreach ($categories as $cat) {
									$category = Category::getByName($cat); ?>
							<a href="<?php echo get_permalink('category', $category->slug) ?>" class="cat-link"><?php echo esc_string($category->name) ?></a>
							<?php
								}
								} ?>
						</p>
						<?php if($options['comments'] === 'true'){
							?>
							<div class="comment-box">
								<div class="box-title">
									<h4><?php _e('Comments') ?></h4>
									<select name="" id="">
										<option value="" selected="">Newest</option>
									</select>
								</div>
								<div id="comments">
									
								</div>
							</div>
							<?php
						} ?>
						<div class="single-comments">
						</div>
					</div>
				</div>
			</div>
			<div class="column is-12-tablet is-3-desktop">
				<?php include  TEMPLATE_PATH . "/includes/sidebar.php" ?>
			</div>
		</div>
	</div>
</section>

<section class="similar-games">
	<div class="container">
		<div class="columns">
			<div class="column is-12">
				<div class="section-title">
					<h3>
						<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/similar.svg" alt="" width="40" height="40"></span> <?php _e('Similar Games') ?>
					</h3>
				</div>
			</div>
		</div>
		<div class="columns is-multiline listing" id="listing1">
			<?php
			$data = get_game_list_categories($categories, 12);
			$games = $data['results'];
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid.php" ?>
			<?php } ?>
		</div>
	</div>
</section>

<?php widget_aside('bottom-content') ?>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>