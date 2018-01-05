<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

$ffmpeg = 0;

if ( isset( $_POST["ffmpeg"] ) )
{
	$ffmpeg = 1;
}

pvs_update_setting('ffmpeg', $ffmpeg);
pvs_update_setting('ffmpeg_video_width', ( int )$_POST["video_width"]);
pvs_update_setting('ffmpeg_video_height', ( int )$_POST["video_height"]);
pvs_update_setting('ffmpeg_path', pvs_result( $_POST["fpath"] ));
pvs_update_setting('ffmpeg_thumb_width', ( int )$_POST["thumb_width"]);
pvs_update_setting('ffmpeg_thumb_height', ( int )$_POST["thumb_height"]);
pvs_update_setting('ffmpeg_frequency', ( int )$_POST["frequency"]);
pvs_update_setting('ffmpeg_duration', ( int )$_POST["duration"]);
pvs_update_setting('ffmpeg_video_format', pvs_result( $_POST["video_format"]));
pvs_update_setting('ffmpeg_watermark', ( int )@$_POST["watermark"]);

?>