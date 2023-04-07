<?php

function list_categories(){
	$categories = get_all_categories();
	echo '<ul class="links list-categories">';
	foreach ($categories as $item) {
		echo '<a href="'. get_permalink('category', $item->slug) .'"><li>'. esc_string($item->name) .'</li></a>';
	}
	echo '</ul>';
}
function list_games($type, $amount){
	// Used for "Game List" widget
	echo '<ul class="sm-post">';
	$data = get_game_list($type, $amount);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
	<li class="widget-list-item">
		<a href="<?php echo get_permalink('game', $game->slug) ?>">
		<div class="pic">
			<figure class="ratio ratio-1 circle list-thumbnail">
				<img src="<?php echo get_small_thumb($game) ?>" class="small-thumb" alt="<?php echo esc_string($game->title) ?>">
			</figure>
		</div>
		<div class="text">
			<h3><div class="list-title ellipsis"><?php echo esc_string($game->title); ?></div></h3>
			<div class="sub-text ellipsis"><?php echo str_replace(',',', ',$game->category) ?></div>
		</div>
		</a>
	</li>
	<?php }
	echo '</ul>';
}
function list_games_by_category($cat, $amount){
	echo '<div class="row">';
	$data = get_game_list_category($cat, $amount);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
		<?php include  TEMPLATE_PATH . "/includes/grid.php" ?>
	<?php }
	echo '</div>';
}
function list_games_by_categories($cat, $amount){
	echo '<div class="row">';
	$data = get_game_list_categories($cat, $amount);
	$games = $data['results'];
	foreach ( $games as $game ) { ?>
		<?php include  TEMPLATE_PATH . "/includes/grid.php" ?>
	<?php }
	echo '</div>';
}

function show_user_profile_header(){

	global $login_user;

	if($login_user){
	?>
	<div class="user-nav">
		<div class="pic">
			<div class="user-pic circle user-avatar">
				<a href="#"><img src="<?php echo get_user_avatar() ?>"></a>
			</div>
			<div class="user-text for-mobile">
				<h5><?php echo $login_user->username ?></h5>
				<i class="orange-text xp-label"><?php echo $login_user->xp ?>xp</i>
			</div>
		</div>
		<div class="user-dropdown">
			<ul class="profile-menu">
				<li class="profile-header for-desktop">
					<h5><?php echo $login_user->username ?></h5>
					<i class="xp-label"><?php echo $login_user->xp ?>xp</i>
				</li>
				<li class="item">
					<a href="<?php echo get_permalink('user', $login_user->username) ?>"><?php _e('My Profile') ?></a>
				</li>
				<li class="item">
					<a href="<?php echo get_permalink('user', $login_user->username, array('edit' => 'edit')) ?>"><?php _e('Edit Profile') ?></a>
				</li>
				<li class="item">
					<a href="<?php echo DOMAIN ?>admin.php?action=logout" class="logout-link"><?php _e('Log Out') ?></a>
				</li>
			</ul>
				
		</div>
	</div>
	<?php
	}
}

register_sidebar(array(
	'name' => 'Head',
	'id' => 'head',
	'description' => 'HTML element before &#x3C;/head&#x3E;',
));

register_sidebar(array(
	'name' => 'Header',
	'id' => 'header',
	'description' => 'Header placement for Header widget',
));

register_sidebar(array(
	'name' => 'Sidebar 1',
	'id' => 'sidebar-1',
	'description' => 'Right sidebar',
));

register_sidebar(array(
	'name' => 'Footer 1',
	'id' => 'footer-1',
	'description' => 'Footer 1',
));

register_sidebar(array(
	'name' => 'Footer 2',
	'id' => 'footer-2',
	'description' => 'Footer 2',
));

register_sidebar(array(
	'name' => 'Footer 3',
	'id' => 'footer-3',
	'description' => 'Footer 3',
));

register_sidebar(array(
	'name' => 'Top Content',
	'id' => 'top-content',
	'description' => 'Above main content element. Recommended for Ad banner placement.',
));

register_sidebar(array(
	'name' => 'Bottom Content',
	'id' => 'bottom-content',
	'description' => 'Under main content element. Recommended for Ad banner placement.',
));

register_sidebar(array(
	'name' => 'Footer Copyright',
	'id' => 'footer-copyright',
	'description' => 'Copyright section.',
));

class widget_game_list extends Widget {
	function __construct() {
 		$this->name = 'Game List';
 		$this->id_base = 'game-list';
 		$this->description = 'Show game list ( Grid ). Is recommedned to put this on sidebar.';
	}
	public function widget( $instance, $args = array() ){
		$label = isset($instance['label']) ? $instance['label'] : '';
		$class = isset($instance['class']) ? $instance['class'] : 'widget';
		$type = isset($instance['type']) ? $instance['type'] : 'new';
		$amount = isset($instance['amount']) ? $instance['amount'] : 9;

		echo '<div class="sm-widget">';
		echo '<div class="'.$class.'">';

		if($label != ''){
			echo '<div class="box-title"><h4>'.$label.'</h4></div>';
		}

		list_games($type, (int)$amount);
		echo '</div></div>';
	}

	public function form( $instance = array() ){

		if(!isset( $instance['label'] )){
			$instance['label'] = '';
		}
		if(!isset( $instance['type'] )){
			$instance['type'] = 'new';
		}
		if(!isset( $instance['amount'] )){
			$instance['amount'] = 9;
		}
		if(!isset( $instance['class'] )){
			$instance['class'] = 'widget';
		}
		?>
		<div class="form-group">
			<label><?php _e('Widget label/title (optional)') ?>:</label>
			<input type="text" class="form-control" name="label" placeholder="NEW GAMES" value="<?php echo $instance['label'] ?>">
		</div>
		<div class="form-group">
			<label><?php _e('Sort game list by') ?>:</label>
			<select class="form-control" name="type">
				<?php

				$opts = array(
					'new' => 'New',
					'popular' => 'Popular',
					'random' => 'Random',
					'likes' => 'Likes'
				);

				foreach ($opts as $key => $value) {
					$selected = '';
					if($key == $instance['type']){
						$selected = 'selected';
					}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				?>
			</select>
		</div>
		<div class="form-group">
			<label><?php _e('Amount') ?>:</label>
			<input type="number" class="form-control" name="amount" placeholder="9" min="1" value="<?php echo $instance['amount'] ?>">
		</div>
		<div class="form-group">
			<label><?php _e('Div class (Optional)') ?>:</label>
			<input type="text" class="form-control" name="class" placeholder="widget" value="<?php echo $instance['class'] ?>">
		</div>
		<?php
	}
}

register_widget( 'widget_game_list' );

class Widget_Header extends Widget {
	function __construct() {
 		$this->name = 'Header';
 		$this->id_base = 'header';
 		$this->description = 'Put this widget on Header placement';
	}
	public function widget( $instance, $args = array() ){
		$_style = '';

		if(isset($instance['bg-img']) && $instance['bg-img'] != ''){
			$_style = 'style="background: url('.$instance['bg-img'].'); background-position: center;"';
		}

		?>
		<section class="section-header">
			<div class="container">
				<div class="columns is-centered">
					<div class="column is-12">
						<div class="header-area <?php echo $instance['style'] ?>">
							<div class="header-bg" <?php echo $_style ?>>
								<div class="column is-8">
									<div class="masthead-title">
										<h1><?php echo htmlspecialchars($instance['title']) ?></h1>
									</div>
									<div class="masthead-description">
										<p><?php echo $instance['content'] ?></p>
									</div>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div>
		</section>
		<?php
	}

	public function form( $instance = array() ){
		if(!isset( $instance['title'] )){
			$instance['title'] = '';
		}
		if(!isset( $instance['content'] )){
			$instance['content'] = '';
		}
		if(!isset( $instance['bg-img'] )){
			$instance['bg-img'] = '';
		}
		if(!isset( $instance['style'] )){
			$instance['style'] = 'basic';
		}
		?>
		<div class="form-group">
			<label>Header Title:</label>
			<input type="text" class="form-control" name="title" value="<?php echo $instance['title'] ?>">
		</div>
		<div class="form-group">
			<label>Description (HTML Allowed):</label>
			<textarea class="form-control" rows="5" name="content"><?php echo $instance['content'] ?></textarea>
		</div>
		<div class="form-group">
			<label>Background image (Optional):</label>
			<input type="text" class="form-control" name="bg-img" placeholder="https://yoursite.com/images/img.jpg" value="<?php echo $instance['bg-img'] ?>">
		</div>
		<div class="form-group">
		    <label>Style:</label>
			<select class="form-control" name="style">
				<?php

				$opts = array(
					'basic' => 'Basic',
					'style1' => 'Style 1',
					'style2' => 'Style 2',
					'style3' => 'Style 3',
					'style4' => 'Style 4'
				);

				foreach ($opts as $key => $value) {
					$selected = '';
					if($key == $instance['style']){
						$selected = 'selected';
					}
					echo '<option value="'.$key.'" '.$selected.'>'.$value.'</option>';
				}
				?>
			</select>
		</div>
		<?php
	}
}

register_widget( 'Widget_Header' );

if(file_exists(ABSPATH . TEMPLATE_PATH . '/includes/custom.php')){
	include(ABSPATH . TEMPLATE_PATH . '/includes/custom.php');
}

?>