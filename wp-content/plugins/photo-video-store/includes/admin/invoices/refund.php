<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_invoices" );

$sql = "select * from " . PVS_DB_PREFIX . "invoices where invoice_number=" . ( int )
	$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$invoice_number = $pvs_global_settings["credit_notes_number"] + 1;

	$sql = "insert into " . PVS_DB_PREFIX .
		"invoices (invoice_number,order_id,order_type,status,comments,refund) values (" .
		$invoice_number . "," . $rs->row["order_id"] . ",'" . $rs->row["order_type"] .
		"'," . $pvs_global_settings["invoice_publish"] . ",'" . $rs->row["comments"] .
		"',1)";
	$db->execute( $sql );
	
	pvs_update_setting('credit_notes_number', $invoice_number);
}
?>
