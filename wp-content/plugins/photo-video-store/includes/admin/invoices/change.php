<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_invoices" );

$sql = "update " . PVS_DB_PREFIX . "invoices set invoice_number=" . ( int )@$_POST["invoice_number"] .
	",comments='" . pvs_result( $_POST["comments"] ) . "' where id=" . ( int )@$_GET["id"];
$db->execute( $sql );

?>
