<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<?php widget_aside('header') ?>

<?php widget_aside('top-content') ?>

<section class="new-games">
	<div class="container-fluid container-section">
		<div class="section-title">
			<h3>
				<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/rocket.svg" alt="" width="40" height="40"></span> <?php _e('New Games') ?>
			</h3>
		</div>
		<div class="row listing" id="listing1">
			<?php
			$games = get_game_list('new', 12)['results'];
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid1.php" ?>
			<?php } ?>
		</div>
		<div class="b-load-more text-center">
			<button class="btn-load-more btn btn-capsule" id="load-more1"><?php _e('Load More') ?></button>
		</div>
	</div>
</section>

<section class="popular">
	<div class="container-fluid container-section">
		<div class="section-title">
			<h3>
				<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/fire.svg" alt="" width="40" height="40"></span> <?php _e('Popular Games') ?>
			</h3>
		</div>
		<div class="row listing" id="listing2">
			<?php
			$games = get_game_list('popular', 8)['results'];
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid2.php" ?>
			<?php } ?>
		</div>
	</div>
</section>

<section class="recomendation">
	<div class="container-fluid container-section">
		<div class="section-title">
			<h3>
				<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/love.svg" alt="" width="40" height="40"></span> <?php _e('You May Like') ?>
			</h3>
		</div>
		<div class="row listing" id="listing3">
			<?php
			$games = get_game_list('random', 6)['results'];
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid3.php" ?>
			<?php } ?>
		</div>
	</div>
</section>

<?php widget_aside('bottom-content') ?>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>