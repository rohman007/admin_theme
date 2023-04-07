<?php

session_start();

require_once( '../../../config.php' );
require_once( '../../../init.php' );

if(is_login() && USER_ADMIN){
	if(isset($_GET['action']) && isset($_GET['name'])){
		$path = ABSPATH . 'admin/backups/' . $_GET['name'];
		if($_GET['action'] == 'delete'){
			echo($path);
			if(file_exists($path)){
				unlink($path);
				header('Location: '.DOMAIN.'admin/dashboard.php?viewpage=plugin&name=backup-restore&status=deleted');
			} else {
				echo('c');
			}
		} else if($_GET['action'] == 'restore') {
			if(file_exists($path)){
				$zip = new ZipArchive;
				$res = $zip->open($path);
				if ($res === TRUE) {
					$zip->extractTo( ABSPATH );
					$zip->close();
					header('Location: '.DOMAIN.'admin/dashboard.php?viewpage=plugin&name=backup-restore&status=restored');
				} else {
				  echo 'doh!';
				}
			} else {
				echo 'not found';
			}
		}
	} else {
		echo('a');
	}
} else {
	exit('logout');
}

?>