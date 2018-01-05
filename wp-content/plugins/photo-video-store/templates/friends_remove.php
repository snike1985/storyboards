<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "delete from " . PVS_DB_PREFIX . "friends where friend1='" . pvs_result( pvs_get_user_login () ) .
	"' and friend2='" . pvs_result_strict( $_GET["user"] ) . "'";
$db->execute( $sql );



header( "location:" . site_url() . "/friends/" );
?>