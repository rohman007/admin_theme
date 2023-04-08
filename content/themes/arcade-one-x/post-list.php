<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<section class="post-list">
	<div class="container">
		<div class="row">
			<div class="col-12">
				<div class="section-title page-title">
				<h2>
					<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/time.svg" alt=""></span> <?php _e('Latest Posts') ?>
				</h2>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12 listing" id="postListing">
				<div class="post-list">
				<?php
					$cur_page = 1;
					if(isset($url_params[1])){
					$_GET['page'] = $url_params[1];
					if(!is_numeric($_GET['page'])){
						$_GET['page'] = 1;
					}
					}
					if(isset($_GET['page'])){
					$cur_page = htmlspecialchars($_GET['page']);
					if(!is_numeric($cur_page)){
						$cur_page = 1;
					}
					}
					$data = Post::getList(6, 'created_date DESC', 6*($cur_page-1));
					$total_posts = $data['totalRows'];
					$total_page = $data['totalPages'];
					$posts = $data['results'];

					foreach($posts as $post){
				?>
					<div class="post-list-card">
						<div class="pic">
						<div class="ratio ratio-4x3">
							<div class="post-thumb">
							<a href="<?php echo get_permalink('post', $post->slug) ?>">
								<img src="<?php echo ($post->thumbnail_url) ? $post->thumbnail_url : DOMAIN . 'images/post-no-thumb.png'  ?>" class="img-fluid">
							</a>
							</div>
						</div>
						</div>
						<div class="text">
						<h3><a href="<?php echo get_permalink('post', $post->slug) ?>"><?php echo $post->title ?></a></h3>
						<span class="meta-info text-italic">Published on <?php echo gmdate("j M Y", $post->created_date) ?></span>
						<div class="post-intro">
							<p><?php echo mb_strimwidth(strip_tags($post->content), 0, 180, "...") ?></p>
						</div>
						<a class="mt-4 read-more-link btn btn-capsule" href="<?php echo get_permalink('post', $post->slug) ?>"><?php _e('Read More') ?></a>
						</div>
					</div>
				<?php
					}
				?>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-12">
				<div class="pagination-wrapper">
					<nav class="pagination justify-content-center" aria-label="Page navigation">
						<ul class="pagination">
							<?php
							if(!isset($_GET['slug'])){
								$_GET['slug'] = '';
							}
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
									echo '<li class="page-item"><a class="page-link" href="'. get_permalink('post', '', array('page' => 1)) .'">1</a></li>';
									echo('<li class="page-item disabled"><span class="page-link">...</span></li>');
								}
								for($i = $start; $i<$end; $i++){
									$current = '';
									if($cur_page){
										if($cur_page == ($i+1)){
											$current = 'active';
										}
									}
									echo '<li class="page-item "><a class="page-link '.$current.'" href="'. get_permalink('post', '', array('page' => $i+1)) .'">'.($i+1).'</a></li>';
								}
								if($end < $total_page){
									echo('<li class="page-item disabled"><span class="page-link">...</span></li>');
									echo '<li class="page-item"><a class="page-link" href="'. get_permalink('post', '', array('page' => $total_page)) .'">'.$total_page.'</a></li>';
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

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>