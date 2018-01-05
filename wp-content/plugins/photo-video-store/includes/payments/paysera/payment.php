<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paysera_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

require_once ( PVS_PATH . 'includes/plugins/paysera/WebToPay.php' );

try
{
	$request = WebToPay::redirectToPayment( array(
		'projectid' => $pvs_global_settings["paysera_account"],
		'sign_password' => $pvs_global_settings["paysera_password"],
		'orderid' => $product_type . "-" . $product_id,
		'amount' => $product_total * 100,
		'currency' => pvs_get_currency_code(1),
		'country' => 'LT',
		'accepturl' => site_url( ) . "/payment-success/",
		'cancelurl' => site_url( ) . "/payment-fail/",
		'callbackurl' => site_url( ) . "/payment-notification/?payment=paysera",
		'test' => 0,
		) );
}
catch ( WebToPayException $e ) {
	// handle exception
}

pvs_show_payment_page( 'footer' );
?>