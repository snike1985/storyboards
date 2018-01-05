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
	pvs_model_delete( ( int )$_GET["id"], pvs_result( pvs_get_user_login () ) );
}



header( "location:" . site_url() . "/models/" );?>