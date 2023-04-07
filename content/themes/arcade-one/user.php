<?php include  TEMPLATE_PATH . "/includes/header.php" ?>
<section class="section-user">
	<div class="container">
		<div class="columns is-multiline">

<?php

$is_visitor = true;
$cur_user = null;

if($login_user && $login_user->username === $_GET['slug']){
	$is_visitor = false;
	$cur_user = $login_user;
} else {
	$cur_user = User::getByUsername(strtolower($_GET['slug']));
}

if(isset($url_params[2]) && $url_params[2] == 'edit'){
	$_GET['edit'] = true;
}

function custom_show_alert($message, $type){
	echo '<div class="divider"></div>';
	echo '<div class="notification is-'.$type.' is-light">';
	echo $message.'</div>';
}

if(true){
	if(isset($_GET['edit']) && !$is_visitor){
		//Edit user profile
		?>
		<div class="column column is-12">
			<div class="section-title page-title">
				<h2>
					<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/user.svg" alt=""></span> <?php _e('Edit Profile') ?>
				</h2>
				<?php
				if(isset($_GET['status'])){
					$type = 'success';
					$message = '';
					if($_GET['status'] == 'saved'){
						$message = 'Profile updated!';
						if(isset($_GET['info']) && $_GET['info'] != ''){
							$message = $_GET['info'];
						}
					} elseif($_GET['status'] == 'error'){
						$type = 'danger';
						$message = 'Error!';
						if(isset($_GET['info'])){
							$message = $_GET['info'];
						}
					}
					custom_show_alert(_t($message), $type);
				}
			?>
			</div>
			
		</div>
			<div class="column column is-8">
				<div class="section">
					<form id="form-settings" action="<?php echo DOMAIN.'includes/user.php' ?>" method="post">
						<input type="hidden" name="action" value="edit_profile">
						<input type="hidden" name="redirect" value="<?php echo get_permalink('user', $login_user->username) ?>&edit">
						<div class="field">
							<label class="label text-label"><?php _e('Email') ?>:</label>
								<div class="control text-label">
								<input class="input" type="text" name="email" minlength="4" value="<?php echo $login_user->email ?>">
							</div>
						</div>
						<div class="field">
							<label class="label text-label"><?php _e('Birth date') ?>:</label>
								<div class="control text-label">
								<input class="input" type="date" name="birth_date" value="<?php echo $login_user->birth_date ?>" required>
							</div>
						</div>
						<div class="field">
							<label class="label text-label"><?php _e('About me') ?>:</label>
								<div class="control text-label">
								<textarea class="textarea" name="bio" rows="3"><?php echo $login_user->bio ?></textarea>
							</div>
						</div>
						<div class="field">
							<label class="label text-label"><?php _e('Gender') ?>:</label>
							<div class="control">
								<label class="radio">
									<input type="radio" name="gender" id="gender1" value="male">
									<?php _e('Male') ?>
								</label>
								<label class="radio">
									<input type="radio" name="gender" id="gender2" value="female">
									<?php _e('Female') ?>
								</label>
								<label class="radio">
									<input type="radio" name="gender" id="gender3" value="unset" checked>
									<?php _e('Unset') ?>
								</label>
							</div>
						</div>
						<div class="divider"></div>
						<button type="submit" class="button-primary"><?php _e('Update') ?></button>
					</form>
				</div>
				</div>
				<div class="column column is-4">
					<?php if($options['upload_avatar'] === 'true'){ ?>
						<div class="section">
							<h3 class="sub-section-title"><?php _e('Upload Avatar') ?></h3>
							<form action="<?php echo DOMAIN.'includes/user.php' ?>" method="post" enctype="multipart/form-data">
								<input type="hidden" name="action" value="upload_avatar">
								<input type="hidden" name="redirect" value="<?php echo get_permalink('user', $login_user->username) ?>&edit">
								<label class="sub-text"><?php _e('Supported format') ?>: png, jpg, jpeg (Max 500kb)</label><br>
								<div class="divider"></div>
								<div class="file-upload">
									<input type="file" name="avatar" accept=".png,.jpg,.jpeg"/><br>
								</div>
								<div class="divider"></div>
								<button type="submit" class="button-primary"><?php _e('Upload') ?></button>
							</form>
						</div>
					<?php } ?>
					<div class="section">
						<h3 class="sub-section-title"><?php _e('Choose Avatar') ?></h3>
						<div class="divider"></div>
						<form action="<?php echo DOMAIN.'includes/user.php' ?>" method="post" enctype="multipart/form-data">
							<div>
								<input type="hidden" name="action" value="choose_avatar">
								<input type="hidden" name="redirect" value="<?php echo get_permalink('user', $login_user->username) ?>&edit">
								<div class="columns is-multiline avatar-chooser">
								<?php
									if(file_exists(ABSPATH.'images/avatar/default/')){
										$avatars = scan_files('images/avatar/default/');
										foreach ($avatars as $avatar) {
											if(substr($avatar, -4) === '.png'){
												$name = basename($avatar, '.png');
												?>
												<div class="column is-3">
														<input type="radio" class="input-hidden" id="avatar-<?php echo $name ?>" name="avatar" value="<?php echo $name ?>" />
														<label for="avatar-<?php echo $name ?>">
															<img src="<?php echo DOMAIN.$avatar ?>">
														</label>
												</div>
												<?php
											}
										}
									}
								?>
								</div>
								<button type="submit" class="button-primary"><?php _e('Change avatar') ?></button>
							</div>
						</form>
					</div>
					<div class="section">
						<h3 class="sub-section-title"><?php _e('Change password') ?></h3>
						<div class="divider"></div>
						<form action="<?php echo DOMAIN.'includes/user.php' ?>" method="post" enctype="multipart/form-data">
							<input type="hidden" name="action" value="change_password">
							<input type="hidden" name="redirect" value="<?php echo get_permalink('user', $login_user->username) ?>&edit">
							<div class="field">
								<label class="label text-label"><?php _e('Current password') ?>:</label>
								<div class="control text-label">
									<input class="input" type="password" name="cur_password" autocomplete="new-password" minlength="6" value="" required>
								</div>
							</div>
							<div class="field">
								<label class="label text-label"><?php _e('New password') ?>:</label>
								<div class="control text-label">
									<input class="input" type="password" name="new_password" minlength="6" value="" required>
								</div>
							</div>
							<div class="divider"></div>
							<button type="submit" class="button-primary"><?php _e('Update') ?></button>
						</form>
					</div>
					<?php if(!USER_ADMIN){ ?>

					<div class="section">
						<h3 class="section-title"><?php _e('Delete account') ?></h3>
						<form action="<?php echo DOMAIN.'includes/user.php' ?>" method="post" enctype="multipart/form-data">
							<div class="form-group">
								<input type="hidden" name="action" value="delete_account">
								<input type="hidden" name="redirect" value="<?php echo get_permalink('user', $login_user->username) ?>&edit">
								<div class="form-group">
									<label><?php _e('Your password') ?>:</label>
									<input type="password" class="form-control" name="cur_password" autocomplete="new-password" minlength="6" value="" required>
								</div>
								<button type="submit" class="btn btn-danger btn-md"><?php _e('Delete') ?></button>
							</div>
						</form>
					</div>

					<?php } ?>
				</div>
		<?php
	} else {
		//User profile page
		$exceeded_value = $rank_values[$cur_user->level-1];
		$max_value = 0;
		$min_value = $cur_user->xp-$exceeded_value;
		if($cur_user->level < count($rank)){
			$max_value = $rank_values[$cur_user->level]-$exceeded_value;
		} else {
			$max_value = 100;
			$min_value = 100;
		}
		$percentage_rank_progress = (100/($max_value))*$min_value;
		?>
		<div class="column column is-12">
			<div class="section-title page-title">
				<h2>
					<span class="g-icon"><img src="<?php echo get_template_path(); ?>/images/icon/user.svg" alt=""></span> <?php _e('User Profile') ?>
				</h2>
			</div>
		</div>
		<div class="column column is-4">
			<div class="section user-profile-info">
				<div class="has-text-centered">
					<br>
					<div class="profile-photo">
						<img src="<?php echo get_user_avatar($cur_user->username) ?>">
					</div>
					<h3 class="profile-username">
						<?php echo $cur_user->username ?>
					</h3>
					<div>
						<?php echo $cur_user->gender ?>
					</div>
					<div class="profile-join">
						<?php _e('Joined %a', $cur_user->join_date) ?>
					</div>
					<div class="profile-bio text-secondary">
						"<?php echo $cur_user->bio ?>"
					</div>
					<br>
				</div>
			</div>
		</div>
		<div class="column column is-8">
			<div class="section">
				<h3 class="sub-section-title"><?php _e('Level') ?></h3>
				<div class="divider"></div>
				<img src="<?php echo DOMAIN.'images/ranks/level-'.$cur_user->level.'.png' ?>" class="level-badge">
				<h4 class="text-label"><?php echo $cur_user->rank ?> (Lv.<?php echo $cur_user->level ?>)</h4>
				<p class="text-secondary"><?php _e('This player have exceeded %a xp', $rank[$cur_user->rank]) ?></p>
				<div class="divider"></div>
				<div class="user-progress">
					<progress class="progress is-success" value="<?php echo $percentage_rank_progress ?>" max="100"><?php echo $percentage_rank_progress ?>%</progress>
				</div>
			</div>
			<?php if(!$is_visitor){ ?>
						<div class="section">
							<h3 class="sub-section-title"><?php _e('Liked Games') ?></h3>
							<div class="divider"></div>
							<div class="profile-gamelist">

							<?php

							if($cur_user){
								if(isset($cur_user->data['likes']) && count($cur_user->data['likes']) > 0){
									?>

									<button class="button is-rounded btn-left" id="btn_prev">
										<img src="<?php echo get_template_path(); ?>/images/icon/prev.svg" alt="">
									</button>
									<button class="button is-rounded btn-right" id="btn_next">
										<img src="<?php echo get_template_path(); ?>/images/icon/next.svg" alt="">
									</button>
									<ul>

									<?php
									$data = $cur_user->data['likes'];
									$total_likes = count($data);
									if($total_likes > 15){
										//Max likes to shown = 15
										$data = array_slice($data, $total_likes-15, $total_likes-1);
									}
									$games = [];
									foreach ($data as $id) {
										$game = new Game;
										$res = $game->getById($id);
										if($res){
											$games[] = $res;
										}
									}
									foreach ($games as $game) {
										?>
											<li><div class="profile-game-item">
											<a href="<?php echo get_permalink('game', $game->slug) ?>">
												<div class="list-thumbnail"><img src="<?php echo get_small_thumb($game) ?>" class="small-thumb" alt="<?php echo esc_string($game->title) ?>"></div>
											</a>
										</div></li>
										
										<?php
									}
									?>

									</ul>

									<?php
								} else {
									echo('<p class="text-secondary">No record!</p>');
								}
							}	

							?>
						</div>
						</div>
						<div class="section">
							<h3 class="sub-section-title"><?php _e('Comments') ?></h3>
							<div class="profile-comments">
								<?php
								$sql = 'SELECT * FROM comments WHERE sender_id = :sender_id ORDER BY parent_id asc, id asc';
								$st = $conn->prepare($sql);
								$st->bindValue(":sender_id", $cur_user->id, PDO::PARAM_INT);
								$st->execute();
								$row = $st->fetchAll(PDO::FETCH_ASSOC);

								if(count($row)){
									foreach ($row as $item) {
										?>
										<div class="profile-comment-item id-<?php echo $item['id'] ?>">
											<div class="comment-text text-label">
												"<?php echo htmlspecialchars($item['comment']) ?>"
											</div>
											<div class="comment-date sub-text">
												<?php echo $item['created_date'] ?> (Game id <?php echo $item['game_id'] ?>)
											</div>
											<div class="has-text-danger delete-comment" data-id="<?php echo $item['id'] ?>">
												<?php _e('Delete') ?>
											</div>
										</div>
										<?php
									}
								} else {
									echo('<p class="sub-text">'._t('No record!').'</p>');
								}
								?>
							</div>
						</div>
					<?php } ?>
		</div>
		<?php
	}
}

?>

		</div>
	</div>
</section>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>