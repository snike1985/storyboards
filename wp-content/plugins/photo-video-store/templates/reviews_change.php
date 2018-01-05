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

$id = ( int )$_REQUEST["id"];

$sql = "update " . PVS_DB_PREFIX . "reviews set content='" . pvs_result( $_REQUEST["content"] ) .
	"' where fromuser='" . pvs_result( pvs_get_user_login () ) .
	"' and id_parent=" . $id;
$db->execute( $sql );

$sql = "select id_parent,fromuser,content from " . PVS_DB_PREFIX .
	"reviews where fromuser='" . pvs_result( pvs_get_user_login () ) .
	"' and id_parent=" . $id;
$rs->open( $sql );
if ( ! $rs->eof ) {
	echo ( $rs->row["content"] );
}

?>