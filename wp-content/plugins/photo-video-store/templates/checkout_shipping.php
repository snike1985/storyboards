<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

include ( "JsHttpRequest.php" );

$JsHttpRequest = &new JsHttpRequest( $mtg );

$shipping = ( float )$_REQUEST["shipping"];
$type = ( int )$_REQUEST["type"];

$_SESSION["product_shipping"] = $shipping;
$_SESSION["product_shipping_type"] = $type;

$taxes_info["included"] = 0;

$sql = "select taxes from " . PVS_DB_PREFIX . "shipping where id=" . $type;
$dr->open( $sql );
if ( ! $dr->eof ) {
	if ( $dr->row["taxes"] == 1 ) {
		pvs_order_taxes_calculate( $_SESSION["product_subtotal"] + $_SESSION["product_shipping"], false,
			"order" );
		$product_tax = $taxes_info["total"];
		$_SESSION["product_tax"] = $product_tax;
	} else {
		pvs_order_taxes_calculate( $_SESSION["product_subtotal"], false, "order" );
		$product_tax = $taxes_info["total"];
		$_SESSION["product_tax"] = $product_tax;
	}
}

$_SESSION["product_total"] = $_SESSION["product_subtotal"] + $_SESSION["product_shipping"] +
	$_SESSION["product_tax"] * $taxes_info["included"] - $_SESSION["product_discount"];

$GLOBALS['_RESULT'] = array(
	"shipping" => pvs_currency( 1 ) . pvs_price_format( $_SESSION["product_shipping"],
		2 ) . " " . pvs_currency( 2 ),
	"total" => "<b>" . pvs_word_lang( "total" ) . ":</b> <span class='price'><b>" .
		pvs_currency( 1 ) . pvs_price_format( $_SESSION["product_total"], 2 ) . " " .
		pvs_currency( 2 ) . "</b></span>",
	"taxes" => pvs_currency( 1 ) . pvs_price_format( $_SESSION["product_tax"], 2 ) .
		" " . pvs_currency( 2 ),
	);
?>
