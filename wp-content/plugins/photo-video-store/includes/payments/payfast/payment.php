<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payfast_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());
?>
<form action="https://www.payfast.co.za/eng/process" method="post"  name="process" id="process">

<!-- Receiver Details -->
<input type="hidden" name="merchant_id" value="<?php echo $pvs_global_settings["payfast_account"] ?>">
<input type="hidden" name="merchant_key" value="<?php echo $pvs_global_settings["payfast_password"] ?>">
<input type="hidden" name="return_url" value="<?php echo (site_url( ) );?>/payment-success/">
<input type="hidden" name="cancel_url" value="<?php echo (site_url( ) );?>/payment-fail/">
<input type="hidden" name="notify_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=payfast">

<!-- Payer Details -->
<input type="hidden" name="name_first" value="<?php echo @$user_info -> first_name ?>">
<input type="hidden" name="email_address" value="<?php echo @$user_info -> user_email ?>">

<!-- Transaction Details -->
<input type="hidden" name="m_payment_id" value="<?php echo $product_type ?>-<?php echo $product_id ?>">
<input type="hidden" name="amount" value="<?php echo pvs_price_format( $product_total, 2 )?>">
<input type="hidden" name="item_name" value="<?php echo $product_name ?>">

<?php
$security_vars = urlencode( "merchant_id=" . $pvs_global_settings["payfast_account"] .
"&merchant_key=" . $pvs_global_settings["payfast_password"] . "&return_url=" . site_url( ) .
"/payment-success/" . "&cancel_url=" . site_url( ) .
"/payment-fail/" . "&notify_url=" . site_url( ) .
"/payment-notification/?payment=payfast" . "&name_first=" . @$user_info -> first_name .
"&m_payment_id=" . $product_type . "-" . $product_id . "&amount=" .
pvs_price_format( $product_total, 2 ) . "&item_name=" . $product_name );?>

<!-- Security -->
<input type="hidden" name="signature" value="">

</form>
<?php
pvs_show_payment_page( 'footer' );
?>