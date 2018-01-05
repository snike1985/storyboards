<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_printspreviews" );

pvs_update_setting('prints_previews', ( int )@$_POST['prints_previews']);
pvs_update_setting('prints_previews_thumb', ( int )@$_POST['prints_previews_thumb']);
pvs_update_setting('prints_previews_width', ( int )$_POST['prints_previews_width']);
?>
