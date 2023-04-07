<?php

session_start();

require_once( '../../../config.php' );
require_once( '../../../init.php' );
require_once( '../../../includes/commons.php' );
require_once( '../../../includes/plugin.php' );

$plugin = get_plugin_info('posts');

require_once($plugin['path'].'/Post.php');

if(is_login() && USER_ADMIN){
	if(isset($_POST['action'])){
		$action = $_POST['action'];
		switch($action){
			case 'newPost':
				$_POST['content'] = $_POST['content'];
				$post = new Post;
				$post->storeFormValues( $_POST );
				$post->insert();
				echo 'newPost';
				break;
			case 'deletePost':
				$post = Post::getById( (int)$_POST['id'] );
				$post->delete();
				echo 'deletePost';
				break;
			case 'getPostData':
				$post = Post::getById( (int)$_POST['id'] );
				$json = json_encode($post);
				echo $json;
				break;
			case 'editPost':
				$_POST['content'] = $_POST['content'];
				$post = Post::getById( (int)$_POST['id'] );
				$post->storeFormValues( $_POST );
				$post->update();
				echo 'editPost';
				break;
		}
	} else {
		echo('a');
	}
} else {
	exit('logout');
}

?>