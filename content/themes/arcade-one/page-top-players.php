<?php
$page_title = 'Top Players';
$meta_description = 'Top Players';

include  TEMPLATE_PATH . "/includes/header.php";

$sql = "SELECT id FROM users ORDER by xp+0 DESC LIMIT 10";
$conn = open_connection();
$st = $conn->prepare($sql);
$st->execute();
$row = $st->fetchAll(PDO::FETCH_ASSOC);

if(count($row) >= 3) {

?>

<section class="mid-ct section-post">
	<div class="container">
		<div class="columns">
			<div class="column column is-12-tablet is-9-desktop">
				<h2 class="has-text-centered">
					<?php _e('Top Players') ?>
				</h2>
				<div class="top-3">
					<?php $user = User::getById($row[1]['id']); ?>
					<div class="top-user rank-2">
						<a href="<?php echo get_permalink('user', $user->username) ?>">
							<div class="top-avatar">
								<img src="<?php echo get_user_avatar($user->username) ?>">
							</div>
						</a>
						<div class="top-number">
							<img src="<?php echo get_template_path() . '/images/medal-2.svg' ?>">
						</div>
						<div class="top-username">
							<?php echo $user->username ?>
						</div>
						<div class="top-xp">
							<?php echo $user->xp ?> xp
						</div>
						<div class="sub-text top-rank">
							<?php echo $user->rank ?>
						</div>
					</div>
					<?php $user = User::getById($row[0]['id']); ?>
					<div class="top-user rank-1">
						<a href="<?php echo get_permalink('user', $user->username) ?>">
							<div class="top-avatar">
								<img src="<?php echo get_user_avatar($user->username) ?>">
							</div>
						</a>
						<div class="top-number">
							<img src="<?php echo get_template_path() . '/images/medal-1.svg' ?>">
						</div>
						<div class="top-username">
							<?php echo $user->username ?>
						</div>
						<div class="top-xp">
							<?php echo $user->xp ?> xp
						</div>
						<div class="sub-text top-rank">
							<?php echo $user->rank ?>
						</div>
					</div>
					<?php $user = User::getById($row[2]['id']); ?>
					<div class="top-user rank-3">
						<a href="<?php echo get_permalink('user', $user->username) ?>">
							<div class="top-avatar">
								<img src="<?php echo get_user_avatar($user->username) ?>">
							</div>
						</a>
						<div class="top-number">
							<img src="<?php echo get_template_path() . '/images/medal-3.svg' ?>">
						</div>
						<div class="top-username">
							<?php echo $user->username ?>
						</div>
						<div class="top-xp">
							<?php echo $user->xp ?> xp
						</div>
						<div class="sub-text top-rank">
							<?php echo $user->rank ?>
						</div>
					</div>
				</div>
				<div>
					<div class="leaderboard-table">
						<?php
						$index = 0;
						foreach($row as $item){
							$user = User::getById($item['id']);
							$index++;
							if($index > 3){
							?>
							<div class="leaderboard-row">
								<div class="leaderboard-cell" style="font-weight: bold;"><?php echo $index ?></div>
								<div class="leaderboard-cell leaderboard-user-avatar">
									<a href="<?php echo get_permalink('user', $user->username) ?>">
										<img src="<?php echo get_user_avatar($user->username) ?>">
									</a>
								</div>
								<div class="leaderboard-cell username"><?php echo $user->username ?></div>
								<div class="leaderboard-cell user-xp"><?php echo $user->xp ?> xp</div>
								<div class="leaderboard-cell rank">
									<div class="leaderboard-cell"><?php echo $user->rank ?></div>
									<div class="leaderboard-cell"><img src="<?php echo DOMAIN.'images/ranks/level-'.$user->level.'.png' ?>" class="level-badge"></div>
								</div>
							</div>
							<?php
							}
						}
						?>
					</div>
				</div>
			</div>
			<div class="column is-12-tablet is-3-desktop">
				<?php include  TEMPLATE_PATH . "/includes/sidebar.php" ?>
			</div>
		</div>
	</div>
</section>

<?php

} else {
	?>
	<h2><?php _e('You must have at least 3 registered users to show the list') ?></h2>
	<?php
}

?>

<?php include  TEMPLATE_PATH . "/includes/footer.php" ?>