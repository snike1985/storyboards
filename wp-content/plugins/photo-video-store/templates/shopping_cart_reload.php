<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = new JsHttpRequest( $mtg );

include ( "shopping_cart_add_content.php" );
$GLOBALS['_RESULT'] = array( "box_shopping_cart" => $box_shopping_cart,
		"box_shopping_cart_lite" => $box_shopping_cart_lite );

?>