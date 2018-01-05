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



$sql = "select id from " . PVS_DB_PREFIX . "media where (userid=" . ( int )
	get_current_user_id() . " or author='" . pvs_result( pvs_get_user_login () ) .
	"') and id=" . ( int )$_GET["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	pvs_publication_delete( ( int )$_GET["id"] );
}



header( "location:" . site_url() . "/upload/" );?>