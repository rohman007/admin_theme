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
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/bootstrap.min.css">
		<link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.10.3/font/bootstrap-icons.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/jquery.mCustomScrollbar.min.css" media="print" onload="this.media='all'">
		<link rel="preconnect" type="text/css" href="https://fonts.googleapis.com">
		<link rel="preconnect" type="text/css" href="https://fonts.gstatic.com" crossorigin>
		<link href="https://fonts.googleapis.com/css2?family=Poppins:wght@300;400;500;600&display=swap" rel="preload" as="style" onload="this.rel='stylesheet'">
		<!-- Font Awesome icons (free version)-->
		<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css" />
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/jquery-comments.css" media="print" onload="this.media='all'">
		<?php if(file_exists(ABSPATH . PLUGIN_PATH . 'posts')){
			echo '<link rel="stylesheet" type="text/css" href="'.DOMAIN.'content/plugins/posts/css/suneditor-content.css">';
		} ?>
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/user.css">
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/style.css?v=<?= rand() ?>">
		<!--<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/skin/<?php echo $selected_skin ?>.css" media="print" onload="this.media='all'">-->
		<link rel="stylesheet" type="text/css" href="<?php echo get_template_path(); ?>/css/custom.css" media="print" onload="this.media='all'">
		<?php widget_aside('head') ?>
	</head>
	<body>
		<div class="master">
			<div class="left-sidebar">
				<div class="side-header">
					<div class="burger-btn burger-left d-lg-none">
						<span class="bi bi-text-paragraph" style="font-size: 35px; color: #fff;"></span>
					</div>
					<div class="site-logo">
						<a href="<?php echo DOMAIN ?>">
							<img src="<?php echo DOMAIN .SITE_LOGO ?>" class="logo" alt="logo">
						</a>
					</div>
					<div class="burger-btn burger-right d-lg-none">
						<span class="bi bi-three-dots-vertical" style="font-size: 30px; color: #fff;"></span>
					</div>
				</div>
				<ul class="left-categories mCustomScrollbar" data-mcs-theme="dark">
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
				<nav class="navbar navbar-expand-lg navbar-dark top-nav" id="mainNav">
					<div class="container-fluid">
						<button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#nav-menu" aria-controls="nav-menu" aria-expanded="false" aria-label="Toggle navigation">
							<span class="navbar-toggler-icon"></span>
						</button>
						<div class="d-lg-none">
							<?php
							if(is_null($login_user)){
								if(isset($options['show_login']) && $options['show_login'] == 'true'){
									echo('<a class="nav-link" href="'.get_permalink('login').'"><div class="btn btn-circle b-white b-login"><i class="bi bi-person"></i></div></a>');
								}
							}
							?>
							<?php show_user_profile_header() ?>
						</div>
						<div class="navbar-collapse collapse" id="nav-menu">
							<form class="form-inline search-bar" action="<?php echo DOMAIN ?>index.php">
								<div class="input-group">
									<input type="hidden" name="viewpage" value="search" />
									<i class="bi bi-search"></i>
									<input type="text" class="form-control search" placeholder="<?php _e('Search game') ?>" name="slug" minlength="2" required  />
								</div>
							</form>
							<ul class="navbar-nav">
								<?php render_nav_menu('top_nav', array(
									'no_ul'				=> true,
									'li_class_parent'	=> 'dropdown',
									'li_class'			=> 'nav-item',
									'a_class'			=> 'nav-link',
									'a_class_parent'	=> 'dropdown-toggle',
									'bs-5'				=> true,
									'after_parent'		=> '',
									'children'			=> array(
										'li_class'			=> '',
										'a_class'			=> 'dropdown-item',
									)
								)); ?>
								<?php
								if(is_null($login_user)){
									if(isset($options['show_login']) && $options['show_login'] == 'true'){
										echo('<li class="nav-item"><a class="nav-link" href="'.get_permalink('login').'">Login</a></li>');
									}
								}
								?>
							</ul>
							<?php show_user_profile_header() ?>
						</div>
					</div>
				</nav>
				<section class="sidebar-right">
					<!-- Mobile Version Right Sidebar -->
						<div class="columns">
							<form class="form-inline search-bar" action="<?php echo DOMAIN ?>index.php">
								<div class="input-group">
									<input type="hidden" name="viewpage" value="search" />
									<i class="bi bi-search"></i>
									<input type="text" class="form-control search" placeholder="<?php _e('Search game') ?>" name="slug" minlength="2" required />
								</div>
							</form>
							<?php show_user_profile_header() ?>
							<ul class="navbar-nav">
								<?php render_nav_menu('top_nav', array(
									'no_ul'				=> true,
									'li_class_parent'	=> 'dropdown',
									'li_class'			=> 'nav-item',
									'a_class'			=> 'nav-link',
									'a_class_parent'	=> 'dropdown-toggle',
									'bs-5'				=> true,
									'after_parent'		=> '',
									'children'			=> array(
										'li_class'			=> '',
										'a_class'			=> 'dropdown-item',
									)
								)); ?>
								<?php
								if(is_null($login_user)){
									if(isset($options['show_login']) && $options['show_login'] == 'true'){
										echo('<li class="nav-item"><a class="nav-link right" href="'.get_permalink('login').'"><div class="btn b-login-right">Login</div></a></li>');
									}
								}
								?>
							</ul>
						</div>
				</section>