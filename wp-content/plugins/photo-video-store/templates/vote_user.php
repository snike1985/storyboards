<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

if ( ! is_user_logged_in() and $pvs_global_settings["users_rating_limited"] ) {
	exit();
}

$sql = "select ip,id from " . PVS_DB_PREFIX . "voteitems_users where ip='" .
	pvs_result( $_SERVER["REMOTE_ADDR"] ) . "' and id=" . ( int )$_REQUEST["id"];
$ds->open( $sql );
if ( $ds->eof ) {
	$sql = "insert into " . PVS_DB_PREFIX . "voteitems_users (id,ip,vote) values (" . ( int )
		$_REQUEST["id"] . ",'" . pvs_result( $_SERVER["REMOTE_ADDR"] ) . "'," . ( float )
		$_REQUEST["vote"] . ")";
	$ds->open( $sql );
}

$item_rating = 0.00;
$item_count = 0;
$sql = "select sum(vote) as sum_vote,count(ip) as count_user from " .
	PVS_DB_PREFIX . "voteitems_users where id=" . ( int )$_REQUEST["id"];
$dr->open( $sql );
if ( ! $dr->eof ) {
	if ( $dr->row["count_user"] != 0 ) {
		$item_rating = $dr->row["sum_vote"] / $dr->row["count_user"];
		$item_count = $dr->row["count_user"];

		update_user_meta( ( int )$_REQUEST["id"], 'rating', $item_rating);
		$db->execute( $sql );
	}
}

?>