<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );


$sql = "select id from " . PVS_DB_PREFIX . "orders";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_REQUEST["sel" . $rs->row["id"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "orders where id=" . $rs->row["id"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "orders_content where id_parent=" . $rs->
			row["id"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "commission where orderid=" . $rs->row["id"];
		$db->execute( $sql );

		$sql = "delete from " . PVS_DB_PREFIX . "downloads where order_id=" . $rs->row["id"];
		$db->execute( $sql );

		pvs_affiliate_delete_commission( $rs->row["id"], "orders" );
	}
	$rs->movenext();
}

?>
