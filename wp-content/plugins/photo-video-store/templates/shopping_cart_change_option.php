<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

$id = ( int )@$_REQUEST['id'];
$i = ( int )@$_REQUEST['i'];
$option_id = ( int )@$_REQUEST['option_id'];
$option_value = pvs_result( $_REQUEST['option_value'] );

$cart_id = pvs_shopping_cart_id();

$sql = "update " . PVS_DB_PREFIX . "carts_content set option" . $i . "_id=" . $option_id .
	",option" . $i . "_value='" . $option_value . "' where id=" . $id .
	" and id_parent=" . $cart_id;
$db->execute( $sql );

include ( "shopping_cart_content.php" );

?>
