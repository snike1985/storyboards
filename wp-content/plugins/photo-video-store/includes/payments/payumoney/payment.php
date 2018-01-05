<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payumoney_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

// Merchant key here as provided by Payu
$MERCHANT_KEY = $pvs_global_settings["payumoney_account"];

// Merchant Salt as provided by Payu
$SALT = $pvs_global_settings["payumoney_password"];

// End point - change to https://secure.payu.in for LIVE mode
if ( $pvs_global_settings["payumoney_test"] ) {
	$PAYU_BASE_URL = "https://test.payu.in/_payment";
} else {
	$PAYU_BASE_URL = "https://secure.payu.in/_payment";
}

$txnid = $product_type . "-" . $product_id;

$productinfo_string = '[{"name":"' . $product_name . '","description":"' . $product_type .
	'","value":"' . $product_id . '","isRequired":"false"}]';

$productinfo = json_encode( json_decode( $productinfo_string ) );

$user_info = get_userdata(get_current_user_id());

$hash_string = $MERCHANT_KEY . "|" . $txnid . "|" . pvs_price_format( $product_total,
	2 ) . "|" . $productinfo . "|" . @$user_info -> first_name . "|" . @$user_info -> user_email .
	"|||||||||||" . $SALT;

$hash = strtolower( hash( 'sha512', $hash_string ) );
?>
<form action="<?php echo $PAYU_BASE_URL ?>" method="post" name="process" id="process">
<input type="hidden" name="key" value="<?php echo $MERCHANT_KEY ?>" />
<input type="hidden" name="hash" value="<?php echo $hash ?>"/>
<input type="hidden" name="txnid" value="<?php echo $txnid ?>" />
<input type="hidden" name="amount" value="<?php echo pvs_price_format( $product_total, 2 )?>">
<input type="hidden" name="firstname" value="<?php echo @$user_info -> first_name ?>" />
<input type="hidden" name="email" value="<?php echo @$user_info -> user_email ?>" />
<input type="hidden" name="phone" value="<?php echo @$user_info -> telephone ?>" />
<input type="hidden" name="productinfo" value='<?php echo $productinfo ?>' />
<input type="hidden" name="surl" value="<?php echo (site_url( ) );?>/payment-notification/?payment=payumoney"/>
<input type="hidden" name="furl" value="<?php echo (site_url( ) );?>/payment-fail/"/>
<input type="hidden" name="service_provider" value='payu_paisa' />
</form> 



<?php
pvs_show_payment_page( 'footer' );
?>