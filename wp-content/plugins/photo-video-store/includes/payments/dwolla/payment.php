<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["dwolla_active"] ) {
	$apiKey = $pvs_global_settings["dwolla_account"];
	$apiSecret = $pvs_global_settings["dwolla_password"];
	$token = '';
	$timestamp = time();
	$order_id = $product_type . "-" . $product_id;

	$signature = hash_hmac( 'sha1', "{$apiKey}&{$timestamp}&{$order_id}", $apiSecret );

	//Test
	//$pvs_global_settings["dwolla_account"]="812-713-9234";

	?>
	
	<form accept-charset="UTF-8" action="https://www.dwolla.com/payment/pay"  method="post" name="process" id="process">
	
	<input id="key" name="key" type="hidden" value="<?php echo $apiKey ?>" />
	<input id="signature" name="signature" type="hidden" value="<?php echo $signature ?>" />
	<input id="callback" name="callback" type="hidden"  value="<?php echo (site_url( ) );?>/payment-notification/?payment=dwolla" />
	<input id="redirect" name="redirect" type="hidden" value="<?php echo (site_url( ) );?>/payment-notification/?payment=dwolla" />
	<input id="test" name="test" type="hidden" value="<?php
		if ( $pvs_global_settings["dwolla_test"]) {
			echo ( "true" );
		} else {
			echo ( "false" );
		}
	?>" />
	<input id="name" name="name" type="hidden" value="<?php echo $product_name ?>" />
	<input id="description" name="description" type="hidden"  value="<?php echo $product_type ?>" />
	<input id="destinationid" name="destinationid" type="hidden"  value="<?php echo $pvs_global_settings["dwolla_account"] ?>" />
	<input id="amount" name="amount" type="hidden" value="<?php echo pvs_price_format( $product_total, 2 )?>" />
	<input id="shipping" name="shipping" type="hidden" value="0.00" />
	<input id="tax" name="tax" type="hidden" value="0.00" />
	<input id="orderid" name="orderid" type="hidden" value="<?php echo $product_type ?>-<?php echo $product_id ?>" />
	<input id="timestamp" name="timestamp" type="hidden"  value="<?php echo $timestamp ?>" />
	</form>
	<?php
}

pvs_show_payment_page( 'footer' );
?>