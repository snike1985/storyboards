<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_admin_panel_access( "catalog_collections" );

$sql = "select id from " . PVS_DB_PREFIX . "collections";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["title" . $rs->row["id"]] ) ) {
		$sql = "update " . PVS_DB_PREFIX . "collections set title='" . pvs_result( $_POST["title" . $rs->row["id"]] ) . "', price=" . ( float ) $_POST["price" . $rs->row["id"]] . " where id=" . $rs->row["id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}


?>
