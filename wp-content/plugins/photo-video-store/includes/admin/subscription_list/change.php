<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_subscription" );

$sql = "select id_parent from " . PVS_DB_PREFIX .
	"subscription_list where id_parent=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "select title from " . PVS_DB_PREFIX . "subscription where id_parent=" . ( int )
		$_POST["subscription"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "subscription_list set title='" . $ds->row["title"] .
			"',user='" . pvs_result( $_POST["user"] ) . "',data1=" . pvs_get_time( 0, 0, 0,
			$_POST["m1"], $_POST["d1"], $_POST["y1"] ) . ",data2=" . pvs_get_time( 23, 59,
			59, $_POST["m2"], $_POST["d2"], $_POST["y2"] ) . ",bandwidth=" . ( float )$_POST["bandwidth"] .
			",bandwidth_limit=" . ( float )$_POST["bandwidth_limit"] . ",subscription=" . ( int )
			$_POST["subscription"] . ",bandwidth_daily_limit=" . ( int )$_POST["bandwidth_daily"] .
			" where id_parent=" . ( int )$_GET["id"];
		$db->execute( $sql );
	}
}

?>
