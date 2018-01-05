<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$user_info = get_userdata(get_current_user_id());

$_FILES['avatar']['name'] = pvs_result_file( $_FILES['avatar']['name'] );

$ext = strtolower( pvs_get_file_info( $_FILES['avatar']['name'], "extention" ) );

if ( $_FILES['avatar']['size'] > 0 and $_FILES['avatar']['size'] < 2 * 1024 * 1024 ) {
	if ( $ext == "jpg" and ! preg_match( "/text/i", $_FILES['avatar']['type'] ) ) {
		$img = pvs_upload_dir() . "/content/users/" . $user_info -> user_login . "." . $ext;
		move_uploaded_file( $_FILES['avatar']['tmp_name'], $img );

		pvs_easyResize( $img, $img, 100, 150 );
		
		update_user_meta( get_current_user_id(), 'avatar', "/content/users/" . $user_info -> user_login . "." . $ext, true );
	}
}

header( "location:" . site_url() . "/profile-about/" );
?>