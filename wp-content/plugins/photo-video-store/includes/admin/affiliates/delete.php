<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );

$sql = "select userid,types,types_id,rates,total,data,aff_referal from " .
	PVS_DB_PREFIX . "affiliates_signups where total>0 ";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["sel" . $rs->row["userid"] . "_" . $rs->row["data"] . "_" . $rs->
		row["types_id"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "affiliates_signups where userid=" . $rs->
			row["userid"] . " and data=" . $rs->row["data"] . " and types_id=" . $rs->row["types_id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}
?>
