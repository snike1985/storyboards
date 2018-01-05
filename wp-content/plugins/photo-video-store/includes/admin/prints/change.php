<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "prints_prints" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "prints_items";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["id_parent"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "prints_items where id_parent=" . $rs->
			row["id_parent"];
		$db->execute( $sql );
	}

	if ( isset( $_POST["quantity_type" . $rs->row["id_parent"]] ) and isset( $_POST["quantity" .
		$rs->row["id_parent"]] ) and isset( $_POST["price" . $rs->row["id_parent"]] ) ) {
		$quantity = ( int )$_POST["quantity" . $rs->row["id_parent"]];
		if ( $_POST["quantity_type" . $rs->row["id_parent"]] == -1 ) {
			$quantity = -1;
		}

		$sql = "update " . PVS_DB_PREFIX . "prints_items set price=" . ( float )$_POST["price" .
			$rs->row["id_parent"]] . ",in_stock=" . $quantity . " where id_parent=" . $rs->
			row["id_parent"];
		$db->execute( $sql );
	}
	$rs->movenext();
}

?>
