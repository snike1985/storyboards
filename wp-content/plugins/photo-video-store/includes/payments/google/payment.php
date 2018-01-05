<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header', true );
?>
<h1>Google Checkout</h1>
<?php
if ( $pvs_global_settings["google_active"] ) {
	$merchant_id = $pvs_global_settings["google_account"]; // Your Merchant ID
	$merchant_key = $pvs_global_settings["google_password"]; // Your Merchant Key
	$server_type = "checkout";
	$currency = pvs_get_currency_code(1);
	
	require_once ( PVS_PATH . 'includes/plugins/google_checkout/googlecart.php' );
	require_once ( PVS_PATH . 'includes/plugins/google_checkout/googleitem.php' );
	require_once ( PVS_PATH . 'includes/plugins/google_checkout/googleshipping.php' );
	require_once ( PVS_PATH . 'includes/plugins/google_checkout/googletax.php' );

	$cart = new GoogleCart( $merchant_id, $merchant_key, $server_type, $currency );
	$total_count = $product_total;

	$item_1 = new GoogleItem( $product_type . ": " . $product_name, // Item name
		$product_id, // Item      description
		1, // Quantity
		$product_total ); // Unit price
	$cart->AddItem( $item_1 );

	// Specify "Return to xyz" link
	$cart->SetContinueShoppingUrl( site_url( ) );

	// Request buyer's phone number
	$cart->SetRequestBuyerPhone( true );

	// Display Google Checkout button
	echo $cart->CheckoutButtonCode( "SMALL" );
}

pvs_show_payment_page( 'footer', true );
?>