<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<?php widget_aside('top-content') ?>

<section class="section-search">
	<div class="container">
		<div class="columns">
			<div class="column is-12">
				<div class="section-title">
					<h3>
						<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/search2.svg" alt=""></span> <?php _e('%a Games', htmlspecialchars($archive_title)) ?>
					</h3>
					<p><?php _e('%a games in total.', esc_int($total_games)) ?> <?php _e('Page %a of %b', esc_int($cur_page), esc_int($total_page)) ?></p>
				</div>
			</div>
		</div>
		<div class="columns is-multiline listing">
			<?php
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid.php" ?>
			<?php } ?>
		</div>
		<div class="pagination-wrapper">
			<nav class="pagination is-rounded is-centered" role="navigation" aria-label="pagination">
				<ul class="pagination-list">
					<?php
					$cur_page = 1;
					if(isset($url_params[2])){
						$cur_page = (int)$url_params[2];
					}
					if($total_page){
						$max = 8;
						$start = 0;
						$end = $max;
						if($max > $total_page){
							$end = $total_page;
						} else {
							$start = $cur_page-$max/2;
							$end = $cur_page+$max/2;
							if($start < 0){
								$start = 0;
							}
							if($end - $start < $max-1){
								$end = $max;
							}
							if($end > $total_page){
								$end = $total_page;
							}
						}
						if($start > 0){
							echo '<li><a class="pagination-link" href="'. get_permalink('search', $_GET['slug'], array('page' => 1)) .'">1</a></li>';
							echo('<li><span class="page-link">...</span></li>');
						}
						for($i = $start; $i<$end; $i++){
							$current = '';
							if($cur_page){
								if($cur_page == ($i+1)){
									$current = 'is-current disabled';
								}
							}
							echo '<li><a class="pagination-link '.$current.'" href="'. get_permalink('search', $_GET['slug'], array('page' => $i+1)) .'">'.($i+1).'</a></li>';
						}
						if($end < $total_page){
							echo('<li><span class="page-link">...</span></li>');
							echo '<li><a class="pagination-link" href="'. get_permalink('search', $_GET['slug'], array('page' => $total_page)) .'">'.$total_page.'</a></li>';
						}
					}
					?>
				</ul>
			</nav>
		</div>
	</div>
</section>

<?php widget_aside('bottom-content') ?>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>