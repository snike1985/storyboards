<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

if ( ! file_exists( pvs_upload_dir() . "/content/audio.mp3" ) )
{
	@copy( plugin_dir_path( __FILE__ ) . "../includes/img/audio.mp3", pvs_upload_dir
		() . "/content/audio.mp3" );
}

if ( file_exists( pvs_upload_dir() . "/content/sox_preview.mp3" ) )
{
	@unlink( pvs_upload_dir() . "/content/sox_preview.mp3" );
}

pvs_generate_mp3( pvs_upload_dir() . "/content/audio.mp3", pvs_upload_dir() .
	"/content/sox_preview.mp3" );
?>