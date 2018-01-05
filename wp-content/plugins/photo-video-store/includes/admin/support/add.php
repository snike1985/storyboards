<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_support" );

$sql = "insert into " . PVS_DB_PREFIX .
	"support_tickets (id_parent,admin_id,user_id,subject,message,data,viewed_admin,viewed_user,rating,closed) values (" . ( int )
	$_GET["id"] . "," . get_current_user_id() . ",0,'','" . pvs_result( $_POST["message"] ) .
	"'," . pvs_get_time() . ",1,0,0,0)";
$db->execute( $sql );

$sql = "update " . PVS_DB_PREFIX . "support_tickets set data=" . pvs_get_time() .
	",closed=0 where id=" . ( int )$_GET["id"];
$db->execute( $sql );

$sql = "select id from " . PVS_DB_PREFIX . "support_tickets where admin_id=" . get_current_user_id() . " order by id desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
	pvs_send_notification( 'support_to_user', $rs->row["id"] );
}
?>
