<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );

$sql = "select * from " . PVS_DB_PREFIX . "payout";
$rs->open( $sql );
while ( ! $rs->eof )
{
	$activ = 0;
	if ( isset( $_POST["activ" . $rs->row["id"]] ) )
	{
		$activ = 1;
	}
	
	if ( isset( $_POST["delete" . $rs->row["id"]] ) )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "payout where id=" . $rs->row["id"];
		$db->execute( $sql );
	}
	else
	{
		$sql = "update " . PVS_DB_PREFIX . "payout set title='" . pvs_result($_POST["title" . $rs->row["id"]]) . "', svalue='" . pvs_result($_POST["svalue" . $rs->row["id"]]) . "', activ=" . $activ .
		" where id=" . $rs->row["id"];
		$db->execute( $sql );		
	}

	$rs->movenext();
}
?>