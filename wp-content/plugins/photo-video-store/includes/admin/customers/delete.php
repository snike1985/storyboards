<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_customers" );

$sql="select ID, user_login from " . $table_prefix . "users";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["ID"]] ) ) {
		if ( file_exists (pvs_upload_dir() . "/content/users/" . $rs->row["user_login"] . ".jpg") ) {
			@unlink(pvs_upload_dir() . "/content/users/" . $rs->row["user_login"] . ".jpg");
		}
	
		wp_delete_user( $rs->row["ID"] ); 
	}
	$rs->movenext();
}

?>
