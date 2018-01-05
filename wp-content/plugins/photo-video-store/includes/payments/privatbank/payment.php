<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["privatbank_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

include ( PVS_PATH . "includes/plugins/liqpay/LiqPay.php" );

if ( $pvs_global_settings["privatbank_account"] != "" ) {
	$liqpay = new LiqPay( $pvs_global_settings["privatbank_account"], $pvs_global_settings["privatbank_password"] );
	$html = $liqpay->cnb_form( array(
		'action' => 'pay',
		'version' => 3,
		'amount' => pvs_price_format( $product_total, 2 ),
		'currency' => pvs_get_currency_code(1),
		'description' => $product_name,
		'order_id' => $product_type . "-" . $product_id,
		'server_url' => site_url( ) . "/payment-notification/?payment=privatbank",
		'result_url' => site_url( ). "/payment-success/" ) );

	echo ( $html );
}


pvs_show_payment_page( 'footer' );
?>