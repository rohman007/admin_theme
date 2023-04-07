<?php
if (session_status() == PHP_SESSION_NONE) {
	session_start();
}
require_once( "../config.php" );
require_once( "../init.php" );

if(count($_POST) == 0){
	$_POST = $_GET;
}

$action = isset( $_POST['action'] ) ? $_POST['action'] : "";
$username = isset( $_SESSION['username'] ) ? $_SESSION['username'] : "";

if ( !$username || !USER_ADMIN ) {
	exit('logout');
}
if(isset($_POST['redirect'])){
	$_POST['redirect'] = esc_url($_POST['redirect']);
}

if( ADMIN_DEMO ){
	if($action == 'getPageData' || $action == 'getGameData' || $action == 'getCategoryData'){
		//
	} else {
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect']);
		}
		exit();
	}
}

switch ( $action ) {
	case 'deleteGame':
		$game = Game::getById( (int)$_POST['id'] );
		if($game){
			$game->delete();
			_trigger_auto_sitemap();
		}
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect'].'&status=deleted');
		}
		break;
	case 'getGameData':
		$page = Game::getById( (int)$_POST['id'] );
		$json = json_encode($page);
		echo $json;
		break;
	case 'editGame':
		$_POST['description'] = html_purify($_POST['description']);
		$_POST['instructions'] = html_purify($_POST['instructions']);
		$_POST['slug'] = esc_slug($_POST['slug']);
		$game = Game::getById( (int)$_POST['id'] );
		$game->storeFormValues( $_POST );
		$game->update();
		break;
	case 'newPage':
		$_POST['content'] = html_purify($_POST['content']);
		$page = new Page;
		$page->storeFormValues( $_POST );
		$page->insert();
		_trigger_auto_sitemap();
		break;
	case 'deletePage':
		$page = Page::getById( (int)$_POST['id'] );
		$page->delete();
		_trigger_auto_sitemap();
		break;
	case 'getPageData':
		$page = Page::getById( (int)$_POST['id'] );
		$json = json_encode($page);
		echo $json;
		break;
	case 'editPage':
		$_POST['content'] = html_purify($_POST['content']);
		$page = Page::getById( (int)$_POST['id'] );
		$page->storeFormValues( $_POST );
		$page->update();
		break;
	case 'editCategory':
		$info = '';
		$_POST['name'] = htmlspecialchars($_POST['name']);
		$category = new Category;
		$exist = $category->isCategoryExist( $_POST['name'] );
		if($exist){
			$_POST['description'] = html_purify($_POST['description']);
			$_POST['meta_description'] = html_purify($_POST['meta_description']);
			$_POST['slug'] = esc_slug($_POST['slug']);
			$category = Category::getById( (int)$_POST['id'] );
			$category->storeFormValues( $_POST );
			$category->update();
		} else { //Update category name
			$_POST['description'] = html_purify($_POST['description']);
			$_POST['meta_description'] = html_purify($_POST['meta_description']);
			$_POST['slug'] = esc_slug($_POST['slug']);
			$category = Category::getById( (int)$_POST['id'] );
			$old_name = $category->name;
			$category->storeFormValues( $_POST );
			$category->update();
			//Update all related games
			$data = Category::getListByCategory($category->id, 10000);
			$games = $data['results'];
			$count = 0;
			foreach ($games as $game) {
				$game->category = str_replace($old_name, $_POST['name'], $game->category);
				$game->update_category();
				$count++;
			}
			$info = '&info=Change '.$old_name.' to '.$_POST['name'].', '.$count.' games affected.';
		}
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect'].'&status=updated'.$info);
		}
		break;
	case 'deleteCategory':
		$category = Category::getById( (int)$_GET['id'] );
		$category->delete();
		$data = Category::getListByCategory((int)$_GET['id'], 10000);
		$games = $data['results'];
		foreach ($games as $game) {
			$game->delete();
		}
		_trigger_auto_sitemap();
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect'].'&status=deleted');
		}
		break;
	case 'newCategory':
		$_POST['name'] = htmlspecialchars($_POST['name']);
		$_POST['description'] = html_purify($_POST['description']);
		$_POST['meta_description'] = html_purify($_POST['meta_description']);
		if(isset($_POST['slug'])){
			$_POST['slug'] = esc_slug($_POST['slug']);
		} else {
			$_POST['slug'] = esc_slug($_POST['name']);
		}
		$category = new Category;
		$exist = $category->isCategoryExist( $_POST['name'] );
		if($exist){
		  //echo 'Category already exist ';
		} else {
		  $category->storeFormValues( $_POST );
		  $category->insert();
		  _trigger_auto_sitemap();
		}
		if(isset($_POST['redirect'])){
			if($exist){
				header('Location: '.$_POST['redirect'].'&status=exist');
			} else {
				header('Location: '.$_POST['redirect'].'&status=added');
			}
		}
		break;
	case 'getCategoryData':
		$data = Category::getById( (int)$_POST['id'] );
		$json = json_encode($data);
		echo $json;
		break;
	case 'newCollection':
		require( dirname(__FILE__).'/../classes/Collection.php' );
		$_POST['name'] = esc_string($_POST['name']);
		$_POST['data'] = preg_replace('/[^0-9,]+/', '', $_POST['data']);
		$collection = new Collection;
		$exist = $collection->isCollectionExist( $_POST['name'] );
		if($exist){
		  //echo 'Collection already exist ';
		} else {
		  $collection->storeFormValues( $_POST );
		  $collection->insert();
		}
		if(isset($_POST['redirect'])){
			if($exist){
				header('Location: '.$_POST['redirect'].'&status=exist');
			} else {
				header('Location: '.$_POST['redirect'].'&status=added');
			}
		}
		break;
	case 'editCollection':
		require( dirname(__FILE__).'/../classes/Collection.php' );
		$_POST['name'] = esc_string($_POST['name']);
		$_POST['data'] = preg_replace('/[^0-9,]+/', '', $_POST['data']);
		$collection = new Collection;
		$collection->storeFormValues( $_POST );
		$collection->update();
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect'].'&status=updated');
		}
		break;
	case 'deleteCollection':
		require( dirname(__FILE__).'/../classes/Collection.php' );
		$collection = Collection::getById( (int)$_GET['id'] );
		$collection->delete();
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect'].'&status=deleted');
		}
		break;
	case 'getCollectionData':
		require( dirname(__FILE__).'/../classes/Collection.php' );
		$data = [];
		$data['collection'] = Collection::getById( (int)$_POST['id'] );
		$data['list'] = [];
		if(isset($data['collection']->data)){
			$arr = commas_to_array($data['collection']->data);
			foreach ($arr as $id) {
				$game = Game::getById($id);
				if($game){
					$data['list'][] = array('id' => $id,'title' => $game->title);
				} else {
					$data['list'][] = array('id' => $id,'title' => 'Game not exist!');
				}
			}
		}
		$json = json_encode($data);
		echo $json;
		break;
	case 'addGame':
		add_game();
		break;
	case 'updateLogo':
		upload_logo();
		break;
	case 'updateLoginLogo':
		upload_login_logo();
		break;
	case 'updateIcon':
		upload_icon();
		break;
	case 'updateStyle':
		update_style();
		break;
	case 'updateTheme':
		update_theme();
		break;
	case 'updateLayout':
		update_layout();
		break;
	case 'updateLanguage':
		update_settings('language', $_POST['language']);
		if(isset($_POST['redirect'])){
			header('Location: '.$_POST['redirect'].'&status=saved');
		}
		break;
	case 'siteSettings':
		site_settings();
		break;
	case 'userSettings':
		user_settings();
		break;
	case 'listingsSettings':
		listings_settings();
		break;
	case 'otherSettings':
		other_settings();
		break;
	case 'set_save_thumbs':
		set_advanced_setting('set_save_thumbs');
		break;
	case 'set_small_thumb':
		set_advanced_setting('set_small_thumb');
		break;
	case 'set_protocol':
		set_advanced_setting('set_protocol');
		break;
	case 'set_prettyurl':
		set_advanced_setting('set_prettyurl');
		break;
	case 'set_custom_slug':
		set_advanced_setting('set_custom_slug');
		break;
	case 'set_unicode_slug':
		set_advanced_setting('set_unicode_slug');
		break;
	case 'set_custom_path':
		update_custom_path();
		break;
	case 'set_option':
		//New method, set_advanced_settings() replacement
		_set_option();
		break;
	case 'updatePurchaseCode':
		update_purchase_code();
		break;
	case 'updater':
		updater2();
		break;
	case 'pluginAction':
		plugin_action();
		break;
	default:
		exit;
	}

?>