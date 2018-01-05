<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_downloads" );

$sql = "select id from " . PVS_DB_PREFIX . "downloads";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "downloads where id=" . $rs->row["id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}

?>
