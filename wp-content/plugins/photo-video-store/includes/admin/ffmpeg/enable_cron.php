<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_ffmpeg" );

pvs_update_setting('ffmpeg_cron', ( int )@$_POST["cron"]);
?>