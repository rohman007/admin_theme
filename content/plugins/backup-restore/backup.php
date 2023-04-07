<?php

session_start();

require( '../../../config.php' );
require( '../../../init.php' );

if(is_login() && USER_ADMIN){
	if(!file_exists( ABSPATH . 'admin/backups' )){
		mkdir(ABSPATH . 'admin/backups', 0755, true);
	}
	$ignored = ['backups'];
	$type = 'part';
	if(isset($_POST['type'])){
		$type = $_POST['type'];
	}
	do_backup('../../../', $type);
	echo 'success';
} else {
	exit('logout');
}

?>