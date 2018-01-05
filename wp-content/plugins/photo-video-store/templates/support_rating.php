<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

if ( ! is_user_logged_in() and $pvs_global_settings["auth_rating"] ) {
	exit();
}

$id = ( int )@$_REQUEST["id"];
$score = ( float )@$_REQUEST["score"];

$sql = "select id_parent from " . PVS_DB_PREFIX . "support_tickets where id=" .
	$id;
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "select id from " . PVS_DB_PREFIX . "support_tickets where id=" . $rs->
		row["id_parent"] . " and user_id=" . get_current_user_id();
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$sql = "update " . PVS_DB_PREFIX . "support_tickets set rating=" . $score .
			" where id=" . $id;
		$db->execute( $sql );
	}
}

?>