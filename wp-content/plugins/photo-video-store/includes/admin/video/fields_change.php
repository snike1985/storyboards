<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );

$sql = "select * from " . PVS_DB_PREFIX . "video_fields order by priority";
$rs->open( $sql );
while ( ! $rs->eof )
{

	$enbl = 0;
	$rqd = 0;
	if ( isset( $_POST["enable" . $rs->row["id"]] ) )
	{
		$enbl = 1;
	}
	if ( isset( $_POST["required" . $rs->row["id"]] ) )
	{
		$rqd = 1;
	}

	$sql = "update " . PVS_DB_PREFIX . "video_fields set priority=" . ( int )$_POST["priority" .
		$rs->row["id"]] . ",activ=" . $enbl . ",required=" . $rqd . "  where id=" . $rs->
		row["id"];
	$db->execute( $sql );

	$rs->movenext();
}
?>