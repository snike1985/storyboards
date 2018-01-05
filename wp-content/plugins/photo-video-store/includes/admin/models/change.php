<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_models" );

$sql = "select id_parent,name from " . PVS_DB_PREFIX . "models";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$sql = "update " . PVS_DB_PREFIX . "models set name='" . pvs_result( $_POST["title" .
		$rs->row["id_parent"]] ) . "' where id_parent=" . $rs->row["id_parent"];
	$db->execute( $sql );
	$rs->movenext();
}
?>
