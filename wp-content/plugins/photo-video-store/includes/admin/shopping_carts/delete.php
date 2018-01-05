<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_carts" );

$sql = "select id from " . PVS_DB_PREFIX . "carts";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "carts where id=" . $rs->row["id"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "carts_content where id_parent=" . $rs->
			row["id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}

?>
