<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<section class="mid-ct section-page">
	<div class="container">
		<div class="columns">
			<div class="column column is-12-tablet is-9-desktop">
				<div class="section-title page-title">
					<h2>
						<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/page.svg" alt=""></span> <?php echo htmlspecialchars( $page->title )?>
					</h2>
				</div>
				<div class="article">
					<div class="article-ct page-content">
						<?php echo nl2br($page->content) ?>
					</div>
				</div>
			</div>
			<div class="column is-12-tablet is-3-desktop">
				<?php include  TEMPLATE_PATH . "/includes/sidebar.php" ?>
			</div>
		</div>
	</div>
</section>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>