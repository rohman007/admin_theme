<?php include  TEMPLATE_PATH . "/includes/header.php" ?>

<section class="py-5 mid-ct">
    <div class="container">
        <div class="row">
            <div class="col-12 col-md-9">
                <div class="section-title page-title">
                    <h3>
                        <span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/page.svg" alt=""></span> <?php echo htmlspecialchars( $page->title )?>
                    </h3>
                </div>
                <div class="article">
                    <div class="page-content">
                        <?php echo nl2br($page->content) ?>
                    </div>
                </div>
            </div>
            <div class="col-12 col-md-3">
                <?php include  TEMPLATE_PATH . "/includes/sidebar.php" ?>
            </div>
        </div>
    </div>
</section>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>
