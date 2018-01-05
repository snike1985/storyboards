<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["rbkmoney_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());

$hash = md5( $pvs_global_settings["rbkmoney_account"] . "::" . str_replace( '.', ',',
		pvs_price_format( $product_total, 2 ) ) . "::" . str_replace( "RUB", "RUR", pvs_get_currency_code(1) ) .
		"::" . @$user_info -> user_email . "::" . $product_type . "::" . $product_type .
		"-" . $product_id . "::::" . $pvs_global_settings["rbkmoney_password"] );?>


<form action="https://rbkmoney.ru/acceptpurchase.aspx" name="process" id="process" method="POST">
<input type="hidden" name="eshopId" value="<?php echo $pvs_global_settings["rbkmoney_account"] ?>">
<input type="hidden" name="orderId" value="<?php echo $product_type ?>-<?php echo $product_id ?>">
<input type="hidden" name="serviceName" value="<?php echo $product_type ?>">
<input type="hidden" name="recipientAmount" value="<?php echo str_replace( '.', ',', pvs_price_format( $product_total, 2 ) )?>">
<input type="hidden" name="recipientCurrency" value="<?php echo str_replace( "RUB", "RUR", pvs_get_currency_code(1) )?>">
<input type="hidden" name="user_email" value="<?php echo @$user_info -> user_email ?>">
<input type="hidden" name="successUrl" value="<?php echo (site_url( ) );?>/payment-success/" ?>">
<input type="hidden" name="failUrl" value="<?php echo (site_url( ) );?>/payment-fail/">
<input type="hidden" name="hash" value="<?php echo $hash ?>">
</form>

<?php

pvs_show_payment_page( 'footer' );
?>