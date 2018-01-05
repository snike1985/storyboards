<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

if ( $pvs_global_settings["sox_watermark_file"] != "" and file_exists( pvs_upload_dir
	() . "/content/watermark.mp3" ) )
{
	$sql = "update " . PVS_DB_PREFIX .
		"settings set svalue='' where setting_key='sox_watermark_file'";
	$db->execute( $sql );

	@unlink( pvs_upload_dir() . "/content/watermark.mp3" );
}
?>