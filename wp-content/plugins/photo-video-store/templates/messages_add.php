<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

//Send to "to"
$sql = "select friend1, friend2 from " .
	PVS_DB_PREFIX . "friends where  friend1='" . pvs_result( pvs_get_user_login () ) .
	"' and friend2='" . pvs_result_strict( $_POST["to"] ) . "'";
$ds->open( $sql );
if ( ! $ds->eof ) {
	$sql = "insert into " . PVS_DB_PREFIX .
		"messages (touser,fromuser,subject,content,data,viewed,trash,del) values ('" .
		pvs_result( $_POST["to"] ) . "','" . pvs_result( pvs_get_user_login () ) .
		"','" . pvs_result( $_POST["subject"] ) . "','" . pvs_result( $_POST["content"] ) .
		"'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) ) . ",0,0,0)";
	$db->execute( $sql );
}

//Send to "cc"
if ( $_POST["cc"] != "" ) {
	$sql = "select friend1, friend2 from " .
	PVS_DB_PREFIX . "friends where  friend1='" . pvs_result( pvs_get_user_login () ) .
	"' and friend2='" . pvs_result_strict( $_POST["cc"] ) . "'";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$sql = "insert into " . PVS_DB_PREFIX .
			"messages (touser,fromuser,subject,content,data,viewed,trash,del) values ('" .
			pvs_result( $_POST["cc"] ) . "','" . pvs_result( pvs_get_user_login () ) .
			"','" . pvs_result( $_POST["subject"] ) . "','" . pvs_result( $_POST["content"] ) .
			"'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
			date( "Y" ) ) . ",0,0,0)";
		$db->execute( $sql );
	}
}

//Send to "bcc"
if ( $_POST["bcc"] != "" ) {
	$sql = "select friend1, friend2 from " .
	PVS_DB_PREFIX . "friends where  friend1='" . pvs_result( pvs_get_user_login () ) .
	"' and friend2='" . pvs_result_strict( $_POST["bcc"] ) . "'";
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$sql = "insert into " . PVS_DB_PREFIX .
			"messages (touser,fromuser,subject,content,data,viewed,trash,del) values ('" .
			pvs_result( $_POST["bcc"] ) . "','" . pvs_result( pvs_get_user_login () ) .
			"','" . pvs_result( $_POST["subject"] ) . "','" . pvs_result( $_POST["content"] ) .
			"'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
			date( "Y" ) ) . ",0,0,0)";
		$db->execute( $sql );
	}
}


header( "location:" . site_url() . "/messages-new/?d=1" );?>