<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_customers" );

$user_info = get_userdata((int)$_GET["id"]);

if ( file_exists (pvs_upload_dir() . "/content/users/" . $user_info->user_login . ".jpg") ) {
	@unlink(pvs_upload_dir() . "/content/users/" . $user_info->user_login . ".jpg");
	
	update_user_meta( $user_info -> ID, 'avatar', '');
}

?>
