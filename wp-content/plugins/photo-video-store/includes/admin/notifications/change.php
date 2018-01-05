<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "users_notifications" );

$sql = "select * from " . PVS_DB_PREFIX . "notifications order by priority";
$rs->open( $sql );
while ( ! $rs->eof ) {
	$enabled = 0;
	if ( isset( $_POST["e" . $rs->row["events"]] ) ) {
		$enabled = 1;
	}

	$sql = "update " . PVS_DB_PREFIX . "notifications set enabled=" . $enabled .
		" where events='" . $rs->row["events"] . "'";
	$db->execute( $sql );

	$rs->movenext();
}
?>
