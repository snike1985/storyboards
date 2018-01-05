<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );

$sql = "select * from " . PVS_DB_PREFIX . "video_ratio";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( isset( $_POST["m" . $rs->row["id"]] ) )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "video_ratio where id=" . $rs->row["id"];
		$db->execute( $sql );
	} else
	{
		$sql = "update " . PVS_DB_PREFIX . "video_ratio set name='" . pvs_result( $_POST["title" .
			$rs->row["id"]] ) . "',width=" . ( int )$_POST["width" . $rs->row["id"]] .
			",height=" . ( int )$_POST["height" . $rs->row["id"]] . " where id=" . $rs->row["id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}
?>