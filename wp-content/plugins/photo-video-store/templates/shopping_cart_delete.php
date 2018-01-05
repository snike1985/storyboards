<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$id = ( int )$_REQUEST["id"];

$cart_id = pvs_shopping_cart_id();

$sql = "delete from " . PVS_DB_PREFIX . "carts_content where id=" . $id .
	" and id_parent=" . $cart_id;
$db->execute( $sql );

include ( "shopping_cart_content.php" );

?>