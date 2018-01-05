<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_documents" );

$sql = "select * from " . PVS_DB_PREFIX . "documents_types order by priority";
$rs->open( $sql );

while ( ! $rs->eof )
{
	$sql = "update " . PVS_DB_PREFIX . "documents_types set title='" . pvs_result( $_POST["title" .
		$rs->row["id"]] ) . "',description='" . pvs_result( $_POST["description" . $rs->
		row["id"]] ) . "',filesize=" . ( int )$_POST["filesize" . $rs->row["id"]] .
		",priority=" . ( int )$_POST["priority" . $rs->row["id"]] . ",enabled=" . ( int )
		@$_POST["enabled" . $rs->row["id"]] . ",buyer=" . ( int )@$_POST["buyer" . $rs->
		row["id"]] . ",seller=" . ( int )@$_POST["seller" . $rs->row["id"]] .
		",affiliate=" . ( int )@$_POST["affiliate" . $rs->row["id"]] . " where id=" . $rs->
		row["id"];
	$db->execute( $sql );

	$rs->movenext();
}
?>