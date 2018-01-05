<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}
$sql = "select id_parent,touser,fromuser,subject,data,viewed,trash,del from " .
	PVS_DB_PREFIX . "messages where touser='" . pvs_result( pvs_get_user_login () ) .
	"' and trash=0 and del=0";
$rs->open( $sql );
while ( ! $rs->eof ) {
	if ( isset( $_POST["m" . $rs->row["id_parent"]] ) ) {
		$sql = "update " . PVS_DB_PREFIX . "messages set trash=1 where id_parent=" . $rs->
			row["id_parent"] . " and  touser='" . pvs_result( pvs_get_user_login () ) .
			"'";
		$db->execute( $sql );
	}
	$rs->movenext();
}



header( "location:" . site_url() . "/messages-trash/" );
?>