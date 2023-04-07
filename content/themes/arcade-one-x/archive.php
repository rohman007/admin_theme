<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<?php widget_aside('top-content') ?>

<section class="section-category">
	<div class="container-fluid container-section">
		<div class="section-title">
			<h3>
				<?php
				$icon = get_category_icon($active_category, $category_icons);
				?>
				<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/<?php echo $icon; ?>.svg" alt=""></span> <?php _e('%a Games', esc_string($archive_title)) ?>
			</h3>
			<p><?php _e('%a games in total.', esc_int($total_games)) ?> <?php _e('Page %a of %b', esc_int($cur_page), esc_int($total_page)) ?></p>
		</div>
		<?php if($category->description != ''){
			?>
			<div class="row">
				<div class="col-md-8">
					<div class="category-description">
						<h4><?php echo $category->description; ?></h4>
					</div>
				</div>
			</div>
			<?php
		} ?>
		<div class="row listing">
			<?php
			foreach ( $games as $game ) { ?>
				<?php include  TEMPLATE_PATH . "/includes/grid1.php" ?>
			<?php } ?>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="pagination-wrapper d-flex justify-content-center">
				<nav class="pagination" role="navigation" aria-label="pagination">
					<ul class="pagination">
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
						echo '<li class="page-item"><a class="page-link" href="'. get_permalink('category', $_GET['slug'], array('page' => 1)) .'">1</a></li>';
						echo('<li class="page-item disabled"><span class="page-link">...</span></li>');
						}
						for($i = $start; $i<$end; $i++){
						$current = '';
						if($cur_page){
							if($cur_page == ($i+1)){
							$current = 'active';
							}
						}
						echo '<li class="page-item "><a class="page-link '.$current.' disabled rounded-circle" href="'. get_permalink('category', $_GET['slug'], array('page' => $i+1)) .'">'.($i+1).'</a></li>';
						}
						if($end < $total_page){
						echo('<li class="page-item "><span class="page-link rounded-circle">...</span></li>');
						echo '<li class="page-item"><a class="page-link rounded-circle" href="'. get_permalink('category', $_GET['slug'], array('page' => $total_page)) .'">'.$total_page.'</a></li>';
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