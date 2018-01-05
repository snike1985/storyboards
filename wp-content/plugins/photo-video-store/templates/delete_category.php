<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( $pvs_global_settings["userupload"] == 0 ) {
	exit;
}

pvs_delete_category( ( int )$_GET["id"], get_current_user_id() );

header( "location:" . site_url() . "/publications/?d=1" );
?>