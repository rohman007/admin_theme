<!DOCTYPE html>
<html lang="en">
	<head>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
		<title><?php echo htmlspecialchars( $page_title )?></title>
		<meta name="description" content="<?php echo substr(esc_string($meta_description), 0, 160) ?>">
		<?php
			if(isset($game)){ //Game page
				?>
				<meta name="twitter:card" content="summary_large_image" />
				<meta name="twitter:title" content="<?php echo htmlspecialchars( $page_title )?>" />
				<meta name="twitter:description" content="<?php echo substr(esc_string($meta_description), 0, 200) ?>" />
				<?php
				if(isset($game->thumb_1)){
					$thumb = $game->thumb_1;
					if(substr($thumb, 0, 1) == '/'){
						$thumb = DOMAIN . substr($thumb, 1);
					}
					echo('<meta name="twitter:image:src" content="'.$thumb.'">');
					echo('<meta property="og:image" content="'.$thumb.'">');
				}
			}
			$selected_skin = get_option('arcade-one-skin');
			if(!$selected_skin){
				$selected_skin = 'default';
			}
		?>
		<?php load_plugin_headers() ?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/normalize.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/bulma.min.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/jquery.mCustomScrollbar.min.css" media="print" onload="this.media='all'">
		<link rel="preconnect" type="text/css" href="https://fonts.googleapis.com">
		<link rel="preconnect" type="text/css" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="preload" as="style" onload="this.rel='stylesheet'">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/jquery-comments.css" media="print" onload="this.media='all'">
		<?php if(file_exists(ABSPATH . PLUGIN_PATH . 'posts')){
			echo '<link rel="stylesheet" type="text/css" href="'.DOMAIN.'content/plugins/posts/css/suneditor-content.css">';
		} ?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/user.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/main.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/skin/<?php echo $selected_skin ?>.css" media="print" onload="this.media='all'">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/custom.css" media="print" onload="this.media='all'">
		<?php widget_aside('head') ?>
	</head>
	<body>
		<div class="master">
			<div class="sidebar">
				<div class="side-header">
					<div class="burger for-mobile">
						<span class="icon-burger"></span>
					</div>
					<a class="logo" href="<?php echo DOMAIN ?>">
						<img src="<?php echo DOMAIN .SITE_LOGO ?>" alt="logo" width="228" height="40">
					</a>
					<div class="bt-more for-mobile">
						<span class="icon-ellipsis"></span>
					</div>
					
				</div>
				<ul class="side-menu mCustomScrollbar" data-mcs-theme="dark">
					<?php
						$active_category = '';
						if(isset($category)){
							$active_category = $url_params[1];
						}
						$category_icons = json_decode( file_get_contents(ABSPATH . TEMPLATE_PATH . '/includes/category-icons.json'), true);
						$categories = get_all_categories();
						foreach ($categories as $item) {
							$active = '';
							$category_title = esc_string($item->name);
							$icon = get_category_icon($item->slug, $category_icons);
							if($active_category == $item->slug){
								$active = 'active';
							}
							?>
							<li class="category-item <?php echo $active ?>">
								<a href="<?php echo get_permalink('category', $item->slug) ?>">
									<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/<?php echo $icon; ?>.svg" alt="<?php echo $category_title ?>" width="40" height="40"></span> <?php echo $category_title ?>
								</a>
							</li>
							<?php
						}
					?>
				</ul>
			</div>
			<div class="g-content">
				<section class="header">
						<div class="columns">
							<div class="column is-4">
								<form action="<?php echo DOMAIN ?>index.php" class="search">
									<input type="hidden" name="viewpage" value="search" />
									<input type="text" placeholder="<?php _e('Search games') ?>" name="slug" minlength="2" required />
									<button style="padding: 0;"><span class="icon-search"></span></button>
								</form>
							</div>
							<div class="column is-8">
								<?php show_user_profile_header(); ?>
								<ul class="main-menu nav-menu">
									<?php render_nav_menu('top_nav', array(
										'no_ul'	=> true,
										'li_class' => 'nav-item',
										'li_class_parent' => 'has-dropdown',
										'a_class' => 'nav-link',
										'after_parent' => '<span class="icon-caret-down"></span>',
										'children' => array(
											'ul_class'			=> 'drop-ct'
										)
									)); ?>
									<li class="nav-item">
										<?php
										if(isset($options['show_login']) && $options['show_login'] == 'true'){
											if(is_null($login_user)){
												echo('<a class="nav-link" href="'.get_permalink('login').'">'._t('Login').'</a>');
											}
										}
										?>
									</li>
								</ul>
							</div>
						</div>
				</section>