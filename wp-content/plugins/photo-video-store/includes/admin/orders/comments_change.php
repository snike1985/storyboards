<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_orders" );

$sql = "update " . PVS_DB_PREFIX . "orders set comments='" . pvs_result( $_POST["comments"] ) .
	"' where  id=" . ( int )$_GET["id"];
$db->execute( $sql );

?>