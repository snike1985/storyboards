<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["webpay_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

	$wsb_seed = 1242649174;
	$wsb_storeid = $pvs_global_settings["webpay_account"];
	$wsb_order_num = $product_type . "-" . $product_id;
	$wsb_test = $pvs_global_settings["webpay_test"];
	$wsb_currency_id = "BYR";
	$wsb_total = $product_total;
	$SecretKey = $pvs_global_settings["webpay_password"];

	$wsb_signature = sha1( $wsb_seed . $wsb_storeid . $wsb_order_num . $wsb_test . $wsb_currency_id . $wsb_total . $SecretKey );

	if ( $pvs_global_settings["webpay_test"] ) {
		$url = "https://secure.sandbox.webpay.by:8843";
	} else {
		$url = "https://payment.webpay.by";
	}
	
	$user_info = get_userdata(get_current_user_id());
?>		
		<form action="<?php echo $url ?>" method="post"  name="process" id="process">
		<input type="hidden" name="*scart">
		<input type="hidden" name="wsb_version" value="2">
		<input type="hidden" name="wsb_language_id" value="russian">
		<input type="hidden" name="wsb_storeid" value="<?php echo $pvs_global_settings["webpay_account"] ?>" >
		<input type="hidden" name="wsb_store" value="<?php echo bloginfo('name') ?>" >
		<input type="hidden" name="wsb_order_num" value="<?php echo $product_type ?>-<?php echo $product_id ?>" >
		<input type="hidden" name="wsb_test" value="<?php echo $pvs_global_settings["webpay_test"] ?>" >
		<input type="hidden" name="wsb_currency_id" value="BYR" >
		<input type="hidden" name="wsb_seed" value="<?php echo $wsb_seed ?>">
		<input type="hidden" name="wsb_return_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=webpay">
		<input type="hidden" name="wsb_cancel_return_url" value="<?php echo (site_url( ) );?>/payment-fail/">
		<input type="hidden" name="wsb_notify_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=webpay">
		<input type="hidden" name="wsb_email" value="<?php echo @$user_info -> user_email ?>" >
		<input type="hidden" name="wsb_invoice_item_name[0]" value="<?php echo $product_name ?>">
		<input type="hidden" name="wsb_invoice_item_quantity[0]" value="1">
		<input type="hidden" name="wsb_invoice_item_price[0]" value="<?php echo $product_total ?>">
		<input type="hidden" name="wsb_total" value="<?php echo $product_total ?>" >
		<input type="hidden" name="wsb_signature" value="<?php echo $wsb_signature ?>" >
		</form>
	<?php

pvs_show_payment_page( 'footer' );
?>