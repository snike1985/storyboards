<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_notifications" );

$sql = "select events,message,subject,html from " . PVS_DB_PREFIX .
	"notifications where events='" . pvs_result( $_REQUEST["events"] ) . "'";
$rs->open( $sql );
if ( ! $rs->eof ) {

	$sql = "update " . PVS_DB_PREFIX . "notifications set subject='" . pvs_result( $_POST["subject"] ) .
		"',message='" . pvs_result( $_POST["message_text"] ) . "',html=" . ( int )$_POST["html"] .
		",message_html='" . pvs_result( $_POST["message_html"] ) . "' where events='" . $rs->row["events"] . "'";
	$db->execute( $sql );
}

?>
