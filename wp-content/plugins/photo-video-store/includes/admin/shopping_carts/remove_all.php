<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_carts" );

$sql = "delete from " . PVS_DB_PREFIX . "carts";
$db->execute( $sql );

$sql = "delete from " . PVS_DB_PREFIX . "carts_content";
$db->execute( $sql );

?>
