<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select id_parent,fromuser,data,content from " . PVS_DB_PREFIX .
	"testimonials where fromuser='" . pvs_result( pvs_get_user_login () ) . "'";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["m" . $rs->row["id_parent"]] ) ) {
		$sql = "delete from " . PVS_DB_PREFIX . "testimonials where id_parent=" . $rs->
			row["id_parent"] . " and  fromuser='" . pvs_result( pvs_get_user_login () ) .
			"'";
		$db->execute( $sql );
	}
	$rs->movenext();
}



header( "location:" . site_url() . "/testimonials/" );?>