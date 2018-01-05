<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );

$sql = "update " . PVS_DB_PREFIX . "downloads set tlimit=0,data=" . ( pvs_get_time
	( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) +
	3600 * 24 * $pvs_global_settings["download_expiration"] ) . " where id=" . ( int )
	$_GET["id"];
$db->execute( $sql );

?>