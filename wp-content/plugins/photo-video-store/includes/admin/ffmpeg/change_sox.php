<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

pvs_update_setting('sox', ( int )@$_POST["sox"]);
pvs_update_setting('sox_path', pvs_result( $_POST["fpath"] ));
pvs_update_setting('sox_duration', ( int )$_POST["duration"]);
pvs_update_setting('sox_library', pvs_result( $_POST["library"] ));
pvs_update_setting('sox_watermark', ( int )@$_POST["watermark_enable"]);


if ( $_FILES['watermark']['size'] > 0 )
{
	if ( 2048 * 1024 >= $_FILES['watermark']['size'] )
	{
		if ( strtolower( pvs_get_file_info( $_FILES['watermark']['name'], "extention" ) ) ==
			"mp3" )
		{
			move_uploaded_file( $_FILES['watermark']['tmp_name'], pvs_upload_dir() .
				"/content/watermark.mp3" );

			$sql = "update " . PVS_DB_PREFIX .
				"settings set svalue='/content/watermark.mp3' where setting_key='sox_watermark_file'";
			$db->execute( $sql );
		}
	}
}
?>