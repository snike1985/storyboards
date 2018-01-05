<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

//Upload function


if ( $pvs_global_settings["model"] == 1 ) {
	if ( isset( $_GET["type"] ) and $_GET["type"] == "modelphoto" ) {
		pvs_model_delete_file( ( int )$_GET["id"], "photo", pvs_result( pvs_get_user_login () ) );
	}
	if ( isset( $_GET["type"] ) and $_GET["type"] == "model" ) {
		pvs_model_delete_file( ( int )$_GET["id"], "file", pvs_result( pvs_get_user_login () ) );
	}
}



header( "location:" . site_url() . "/models-content/?id=" . $_GET["id"] );?>