			<section class="footer">
				<div class="container">
					<div class="columns pt-5 pb-5">
						<div class="column is-4">
							<?php widget_aside('footer-1') ?>
						</div>
						<div class="column is-4">
							<?php widget_aside('footer-2') ?>
						</div>
						<div class="column is-4">
							<?php widget_aside('footer-3') ?>
						</div>
					</div>
				</div>
			</section>
			<section class="section-copyright">
				<div class="container">
					<p class="copyright">
						<?php
						if(isset($stored_widgets['footer-copyright'])){
							widget_aside('footer-copyright');
						} else {
							echo SITE_TITLE . ' © 2022. All rights reserved.';
						}
						?>
						<span class="dsb-panel">
							<?php
							if(is_login() && USER_ADMIN ){
								echo '<a href="'.DOMAIN.'admin.php">Admin Dashboard</a>';
							} else {
								echo 'V-'.VERSION;
							}
							?>
						</span>
					</p>
				</div>
			</section>
		</div>
	</div>
	<script type="text/javascript" src="<?php echo DOMAIN . TEMPLATE_PATH ?>/js/jquery-3.6.1.min.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN . TEMPLATE_PATH ?>/js/jquery.mCustomScrollbar.concat.min.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN ?>js/jquery-comments.min.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN . TEMPLATE_PATH ?>/js/main.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN . TEMPLATE_PATH ?>/js/custom.js"></script>
	<script type="text/javascript" src="<?php echo DOMAIN ?>js/stats.js"></script>
	<?php load_plugin_footers() ?>
</body>
</html>