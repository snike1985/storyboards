<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( ! $pvs_global_settings["authorize_active"] ) {
	exit();
}
$loginID = $pvs_global_settings["authorize_account"];
$transactionKey = $pvs_global_settings["authorize_password"];
$amount = $product_total;
$description = $product_type;
$testMode = "false";
$invoice = $product_id;
$sequence = rand( 1, 1000 );
$timeStamp = time();

$fingerprint = hash_hmac( "md5", $loginID . "^" . $sequence . "^" . $timeStamp . "^" . $amount . "^", $transactionKey );
?>
<form action="https://secure.authorize.net/gateway/transact.dll" method="POST" name="process" id="process">
<input type='hidden' name='x_login' value='<?php echo $loginID; ?>' />
<input type='hidden' name='x_amount' value='<?php echo $amount; ?>' />
<input type='hidden' name='x_description' value='<?php echo $description; ?>' />
<input type='hidden' name='x_invoice_num' value='<?php echo $invoice; ?>' />
<input type='hidden' name='x_fp_sequence' value='<?php echo $sequence; ?>' />
<input type='hidden' name='x_fp_timestamp' value='<?php echo $timeStamp; ?>' />
<input type='hidden' name='x_fp_hash' value='<?php echo $fingerprint; ?>' />
<input type='hidden' name='x_test_request' value='<?php echo $testMode; ?>' />
<?php
if ( $pvs_global_settings["authorize_ipn"] == true ) {
?>
	<input type="hidden" name="x_relay_response" value="TRUE"/>
	<input type="hidden" name="x_relay_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=authorize" ?>"/>
<?php
}
?>
<input type='hidden' name='x_show_form' value='PAYMENT_FORM' />
</form>
<?php


pvs_show_payment_page( 'footer' );
?>