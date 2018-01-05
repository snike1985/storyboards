<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "insert into " . PVS_DB_PREFIX .
	"galleries (user_id,title,data) values (" . get_current_user_id() . ",'" .
	pvs_result( $_POST["title"] ) . "'," . pvs_get_time( date( "H" ), date( "i" ),
	date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . ")";
$db->execute( $sql );

header( "location:" . site_url() . "/printslab/" );?>

