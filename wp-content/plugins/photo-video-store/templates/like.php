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

$rating_text = "";

$sql = "select ip,id from " . PVS_DB_PREFIX . "voteitems2 where ip='" .
	pvs_result( $_SERVER["REMOTE_ADDR"] ) . "' and id=" . ( int )$_REQUEST["id"];
$ds->open( $sql );
if ( $ds->eof ) {
	$sql = "insert into " . PVS_DB_PREFIX . "voteitems2 (id,ip,vote) values (" . ( int )
		$_REQUEST["id"] . ",'" . pvs_result( $_SERVER["REMOTE_ADDR"] ) . "'," . ( int )
		$_REQUEST["vote"] . ")";
	$ds->open( $sql );

	if ( $_REQUEST["vote"] > 0 ) {
		$com = "vote_like=vote_like+1";
		$rating_text = pvs_word_lang( "like" ) . " ";
	} else {
		$com = "vote_dislike=vote_dislike+1";
		$rating_text = pvs_word_lang( "dislike" ) . " ";
	}

	$sql = "update " . PVS_DB_PREFIX . "media set " . $com .
		" where id=" . ( int )$_REQUEST["id"];
	$db->execute( $sql );

	$vote_like = 0;
	$vote_dislike = 0;
	$sql = "select vote_like,vote_dislike from " . PVS_DB_PREFIX .
		"media where id=" . ( int )$_REQUEST["id"];
	$dr->open( $sql );
	if ( ! $dr->eof ) {
		$vote_like = $dr->row["vote_like"];
		$vote_dislike = $dr->row["vote_dislike"];
	}

	if ( $_REQUEST["vote"] > 0 ) {
		$rating_text .= $vote_like;
	} else {
		$rating_text .= $vote_dislike;
	}
}

echo ( $rating_text );
?>