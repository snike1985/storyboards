<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

$dir = opendir( pvs_upload_dir() . "/content" );
while ( $file = readdir( $dir ) )
{
	if ( $file <> "." && $file <> ".." )
	{
		if ( preg_match( "/thumb/i", $file ) )
		{
			@unlink( pvs_upload_dir() . "/content/" . $file );
		}
	}
}
closedir( $dir );

if ( ! file_exists( pvs_upload_dir() . "/content/video.avi" ) )
{
	@copy( plugin_dir_path( __FILE__ ) . "../includes/img/video.avi", pvs_upload_dir
		() . "/content/video.avi" );
}

pvs_generate_video_preview( pvs_upload_dir() . "/content/video.avi", 0, 0 );
?>