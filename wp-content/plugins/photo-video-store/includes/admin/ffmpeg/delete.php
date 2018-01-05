<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

$sql = "select id from " . PVS_DB_PREFIX . "ffmpeg_cron order by data1 desc";
$rs->open( $sql );
while ( ! $rs->eof )
{
	if ( isset( $_POST["delete" . $rs->row["id"]] ) )
	{
		$sql = "delete from " . PVS_DB_PREFIX . "ffmpeg_cron where id=" . $rs->row["id"];
		$db->execute( $sql );
	}
	$rs->movenext();
}
?>
