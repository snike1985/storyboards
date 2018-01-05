<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_messages" );

$sql = "select user_login from " . $table_prefix . "users where user_login='" . pvs_result( $_POST["to"] ) . "'";
$ds->open( $sql );
if ( ! $ds->eof ) {
	$sql = "insert into " . PVS_DB_PREFIX .
		"messages (touser,fromuser,subject,content,data,viewed,trash,del) values ('" .
		pvs_result( $_POST["to"] ) . "','" . pvs_get_user_login () . "','" . pvs_result( $_POST["subject"] ) .
		"','" . pvs_result( $_POST["content"] ) . "'," . pvs_get_time() . ",0,0,0)";
	$db->execute( $sql );
}
?>
