<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( pvs_get_user_type () == "" ) {
	if ( preg_match( "/^fb/i", pvs_get_user_login () ) and $_REQUEST['login'] !=
		pvs_get_user_login () ) {
		$sql = "select login from " . PVS_DB_PREFIX . "users where login='" . pvs_result( $_POST["login"] ) .
			"'";
		$ds->open( $sql );
		if ( $ds->eof ) {
			if ( ! preg_match( "/^[A-Za-z]{1,}[A-Za-z0-9]{4,}$/", $_REQUEST['login'] ) )
			{
				header( "location:" . site_url() . "/profile/?d=1" );
				exit();
			} else
			{
				$sql = "update " . PVS_DB_PREFIX . "users set login='" . pvs_result( $_REQUEST['login'] ) .
					"' where login='" . pvs_result( pvs_get_user_login () ) . "'";
				$db->execute( $sql );
				pvs_get_user_login () = pvs_result( $_REQUEST['login'] );
			}
		} else {
			header( "location:" . site_url() . "/profile/?d=1" );
			exit();
		}
	}

	$sql = "update " . PVS_DB_PREFIX . "users set utype='" . pvs_result( $_POST["utype"] ) .
		"' where id_parent=" . get_current_user_id();
	$db->execute( $sql );
	pvs_get_user_type () = pvs_result( $_POST["utype"] );
	if ( pvs_get_user_type () == "buyer" or pvs_get_user_type () == "seller" ) {
		if ( isset( $_COOKIE["aff"] ) ) {
			pvs_affiliate_add( ( int )$_COOKIE["aff"], get_current_user_id(), pvs_get_user_type () );
		}
	}

}



if ( isset( $_SESSION["redirect_url"] ) and $_SESSION["redirect_url"] ==
	"checkout" ) {
	header( "location:" . site_url() . "/checkout/" );
	exit();
} else
{
	header( "location:" . site_url() . "/profile/" );
	exit();
}
?>