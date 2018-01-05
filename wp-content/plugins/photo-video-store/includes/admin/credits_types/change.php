<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_creditstypes" );

$sql = "select id_parent,title,quantity,price,priority,days from " .
	PVS_DB_PREFIX . "credits";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sql = "update " . PVS_DB_PREFIX . "credits set title='" . pvs_result( $_POST["title" .
		$rs->row["id_parent"]] ) . "',quantity=" . ( int )$_POST["quantity" . $rs->row["id_parent"]] .
		",price=" . ( float )$_POST["price" . $rs->row["id_parent"]] . ",priority=" . ( int )
		$_POST["priority" . $rs->row["id_parent"]] . ",days=" . ( int )$_POST["days" . $rs->
		row["id_parent"]] . " where id_parent=" . $rs->row["id_parent"];
	$db->execute( $sql );

	$rs->movenext();
}
?>
