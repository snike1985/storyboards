<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["dotpay_active"] ) {
?>
		<form action="https://ssl.dotpay.pl/" name="process" id="process" method="POST">
			<input type="hidden" name="id" value="<?php echo $pvs_global_settings["dotpay_account"] ?>">
			<input type="hidden" name="amount" value="<?php echo pvs_price_format( $product_total, 2 )?>">
			<input type="hidden" name="currency" value="<?php echo pvs_get_currency_code(1) ?>">
			<input type="hidden" name="description" value="<?php echo $product_type ?>-<?php echo $product_id ?>">
			<input type="hidden" name="lang" value="en">
			<input type="hidden" name="URL" value="<?php echo (site_url( ) );?>/payment-success/">
			<input type="hidden" name="URLC" value="<?php echo (site_url( ) );?>/payment-notification/?payment=dotpay">
		</form>
<?php
}

pvs_show_payment_page( 'footer' );
?>