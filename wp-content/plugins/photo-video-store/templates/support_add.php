<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

if ( isset( $_GET["id"] ) ) {
	$id_parent = ( int )$_GET["id"];
	$subject = "";
} else
{
	$id_parent = 0;
	$subject = pvs_result( $_POST["subject"] );
}

$sql = "insert into " . PVS_DB_PREFIX .
	"support_tickets (id_parent,admin_id,user_id,subject,message,data,viewed_admin,viewed_user,rating,closed) values (" .
	$id_parent . ",0," . get_current_user_id() . ",'" . $subject . "','" .
	pvs_result( $_POST["message"] ) . "'," . pvs_get_time( date( "H" ), date( "i" ),
	date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . ",0,1,0,0)";
$db->execute( $sql );

$sql = "select id from " . PVS_DB_PREFIX . "support_tickets where user_id=" . ( int )
	get_current_user_id() . " order by id desc";
$rs->open( $sql );
if ( ! $rs->eof ) {
	pvs_send_notification( 'support_to_admin', $rs->row["id"] );
}

if ( $id_parent != 0 ) {
	$sql = "update " . PVS_DB_PREFIX . "support_tickets set data=" . pvs_get_time( date
		( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) .
		",closed=0 where id=" . $id_parent;
	$db->execute( $sql );
}

header( "location:" . site_url() . "/support/?d=1" );?>