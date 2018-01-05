<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );

$sql = "select id_parent from " . PVS_DB_PREFIX . "prints order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( isset( $_POST["print" . $rs->row["id_parent"]] ) )
	{
		$sql = "update " . PVS_DB_PREFIX . "pwinty_prints set activ=1,title='" .
			pvs_result( $_POST["title" . $rs->row["id_parent"]] ) . "' where print_id=" . $rs->
			row["id_parent"];
	} else
	{
		$sql = "update " . PVS_DB_PREFIX . "pwinty_prints set activ=0,title='" .
			pvs_result( $_POST["title" . $rs->row["id_parent"]] ) . "' where print_id=" . $rs->
			row["id_parent"];
	}

	$db->execute( $sql );

	$rs->movenext();
}
?>