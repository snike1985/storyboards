<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_commission" );

$sql = "delete from " . PVS_DB_PREFIX . "commission where id=" . ( int )$_GET["id"];
$db->execute( $sql );

?>
