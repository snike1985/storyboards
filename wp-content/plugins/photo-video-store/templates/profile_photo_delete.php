<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$user_info = get_userdata(get_current_user_id());

if ( file_exists (pvs_upload_dir() . "/content/users/" . $user_info->user_login . ".jpg") ) {
	@unlink(pvs_upload_dir() . "/content/users/" . $user_info->user_login . ".jpg");
	
	update_user_meta( $user_info -> ID, 'avatar', '');
}

header( "location:" . site_url() . "/profile-about/" );
?>





