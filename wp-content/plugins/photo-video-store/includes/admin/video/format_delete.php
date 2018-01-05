<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_video" );

$sql = "select * from " . PVS_DB_PREFIX . "video_format";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( isset( $_POST["m" . $rs->row["id"]] ) )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "video_format where id=" . $rs->row["id"];
		$db->execute( $sql );
	} else
	{
		$sql = "update " . PVS_DB_PREFIX . "video_format set name='" . pvs_result( $_POST["title" .
			$rs->row["id"]] ) . "' where id=" . $rs->row["id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}
?>