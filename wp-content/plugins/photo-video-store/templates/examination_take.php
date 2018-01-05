<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select id from " . PVS_DB_PREFIX . "examinations where user=" . ( int )
	get_current_user_id();
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "update " . PVS_DB_PREFIX . "examinations set data=" . pvs_get_time( date
		( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) .
		" where id=" . $rs->row["id"];
	$db->execute( $sql );
	pvs_send_notification( 'exam_to_admin', get_current_user_id(), $rs->row["id"],
		"", "" );
} else
{
	$sql = "insert into " . PVS_DB_PREFIX .
		"examinations (user,data,status) values (" . get_current_user_id() . "," .
		pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) ) . ",0)";
	$db->execute( $sql );

	$sql = "select id from " . PVS_DB_PREFIX . "examinations where user=" . ( int )
		get_current_user_id();
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		pvs_send_notification( 'exam_to_admin', get_current_user_id(), $ds->row["id"],
			"", "" );
	}
}



header( "location:" . site_url() . "/upload/" );?>