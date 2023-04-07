<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<?php widget_aside('top-content') ?>

<section class="section-category">
	<div class="container">
		<div class="columns">
			<div class="column is-12">
				<div class="section-title">
					<h3>
						<?php
						$icon = get_category_icon($active_category, $category_icons);
						?>
						<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/<?php echo $icon; ?>.svg" alt=""></span> <?php _e('%a Games', esc_string($archive_title)) ?>
					</h3>
					<p><?php _e('%a games in total.', esc_int($total_games)) ?> <?php _e('Page %a of %b', esc_int($cur_page), esc_int($total_page)) ?></p>
				</div>
			</div>
		</div>
		<?php if($category->description != ''){
			?>
			<div class="columns">
				<div class="column is-8">
					<div class="section has-text-centered">
						<h4><?php echo $category->description; ?></h4>
					</div>
				</div>
			</div>
			<?php
		} ?>
		<div class="columns is-multiline listing">
			<?php
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid.php" ?>
			<?php } ?>
		</div>
		<div class="columns">
			<div class="column is-12">
				<div class="pagination-wrapper">
					<nav class="pagination is-rounded is-centered" role="navigation" aria-label="pagination">
						<ul class="pagination-list">
							<?php
							$cur_page = 1;
							if(isset($_GET['page'])){
								$cur_page = esc_string($_GET['page']);
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
									echo '<li><a class="pagination-link" href="'. get_permalink('category', $_GET['slug'], array('page' => 1)) .'">1</a></li>';
									echo('<li><span class="page-link">...</span></li>');
								}
								for($i = $start; $i<$end; $i++){
									$current = '';
									if($cur_page){
										if($cur_page == ($i+1)){
											$current = 'is-current disabled';
										}
									}
									echo '<li><a class="pagination-link '.$current.'" href="'. get_permalink('category', $_GET['slug'], array('page' => $i+1)) .'">'.($i+1).'</a></li>';
								}
								if($end < $total_page){
									echo('<li><span class="page-link">...</span></li>');
									echo '<li><a class="pagination-link" href="'. get_permalink('category', $_GET['slug'], array('page' => $total_page)) .'">'.$total_page.'</a></li>';
								}
							}
							?>
						</ul>
					</nav>
				</div>
			</div>
		</div>
	</div>
</section>

<?php widget_aside('bottom-content') ?>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>