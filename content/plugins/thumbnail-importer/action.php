<?php

session_start();

require_once( '../../../config.php' );
require_once( '../../../init.php' );
require_once( '../../../includes/commons.php' );

if(is_login() && USER_ADMIN && !ADMIN_DEMO){
	if(isset($_POST['action']) && ($_POST['action'] == 'import' || $_POST['action'] == 'generate-small')){
		$id = (int)$_POST['id'];
		$game = Game::getById($id);
		if($game){
			if($_POST['action'] == 'import' && substr($game->thumb_1, 0, 4) == 'http'){
				if( IMPORT_THUMB ){
					// Check if webp is activated
					$use_webp = get_option('webp-thumbnail');
					import_thumb($game->thumb_2, $game->slug);
					$name = basename($game->thumb_2);
					$game->thumb_2 = '/thumbs/'.$game->slug.'-'.$name;
					if($use_webp){
						$file_extension = pathinfo($game->thumb_2, PATHINFO_EXTENSION);
						$game->thumb_2 = str_replace('.'.$file_extension, '.webp', $game->thumb_2);
					}
					//
					import_thumb($game->thumb_1, $game->slug);
					$name = basename($game->thumb_1);
					$game->thumb_1 = '/thumbs/'.$game->slug.'-'.$name;
					if($use_webp){
						$file_extension = pathinfo($game->thumb_1, PATHINFO_EXTENSION);
						$game->thumb_1 = str_replace('.'.$file_extension, '.webp', $game->thumb_1);
					}
					if( SMALL_THUMB ){
						$output = pathinfo($game->thumb_2);
						$game->thumb_small = '/thumbs/'.$game->slug.'-'.$output['filename'].'_small.'.$output['extension'];
						if($use_webp){
							$file_extension = pathinfo($game->thumb_2, PATHINFO_EXTENSION);
							$game->thumb_small = str_replace('.'.$file_extension, '.webp', $game->thumb_small);
							webp_resize('../../..'.$game->thumb_2, '../../..'.$game->thumb_small, 160, 160);
						} else {
							imgResize('../../..'.$game->thumb_2, 160, 160, $game->slug);
						}
					}
					$game->update();
					echo 'ok';
				}
			} elseif($_POST['action'] == 'generate-small'){
				if( SMALL_THUMB ){
					$output = pathinfo($game->thumb_2);
					$game->thumb_small = '/thumbs/'.$game->slug.'-'.$output['filename'].'_small.'.$output['extension'];
					if($use_webp){
						$file_extension = pathinfo($game->thumb_2, PATHINFO_EXTENSION);
						$game->thumb_small = str_replace('.'.$file_extension, '.webp', $game->thumb_small);
						webp_resize('../../..'.$game->thumb_2, '../../..'.$game->thumb_small, 160, 160);
					} else {
						imgResize('../../..'.$game->thumb_2, 160, 160, $game->slug);
					}
				}
				$game->update();
				echo 'ok';
			} else {
				echo substr($game->thumb_1, 0, 4);
			}
		} else {
			var_dump($game);
		}
	} else {
		echo('a');
	}
} else {
	echo 'x';
}
function import_thumb($url, $game_slug){
	if($url) {
		if (!file_exists('../../../thumbs')) {
			mkdir('../../../thumbs', 0777, true);
		}
		$name = basename($url);
		$new = '../../../thumbs/'.$game_slug.'-'.$name;
		if( get_option('webp-thumbnail') ){
			// Using WEBP format
			$file_extension = pathinfo($url, PATHINFO_EXTENSION);
			$new = str_replace('.'.$file_extension, '.webp', $new);
			image_to_webp($url, 85, $new);
		} else {
			compressImage($url, $new , COMPRESSION_LEVEL);
		}
	}
}
function compressImage($source, $destination, $quality) {
	$info = getimagesize($source);
	if ($info['mime'] == 'image/jpeg') 
	$image = imagecreatefromjpeg($source);
	elseif ($info['mime'] == 'image/gif') 
	$image = imagecreatefromgif($source);
	elseif ($info['mime'] == 'image/png') 
	$image = imagecreatefrompng($source);

	if ($info['mime'] == 'image/png'){
		imageAlphaBlending($image, true);
		imageSaveAlpha($image, true);
		imagepng($image, $destination, 9);
	} else {
		imagejpeg($image, $destination, $quality);
	}
}

?>