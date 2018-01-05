<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );

if (isset($_REQUEST["collection_id"])) {
	$sql = "update " . PVS_DB_PREFIX . "downloads set tlimit=0,data=" . ( pvs_get_time
		( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) +
		3600 * 24 * $pvs_global_settings["download_expiration"] ) . " where  order_id=" . ( int )
		$_REQUEST["id"] . " and  collection_id=" . ( int )$_REQUEST["collection_id"];
	$db->execute( $sql );
} else {
	$sql = "update " . PVS_DB_PREFIX . "downloads set tlimit=0,data=" . ( pvs_get_time
		( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) +
		3600 * 24 * $pvs_global_settings["download_expiration"] ) . " where  order_id=" . ( int )
		$_REQUEST["id"] . " and  id_parent=" . ( int )$_REQUEST["link_id"];
	$db->execute( $sql );
}
?>