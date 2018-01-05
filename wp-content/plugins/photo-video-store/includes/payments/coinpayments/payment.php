<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["coinpayments_active"] ) {
?>
<form action="https://www.coinpayments.net/index.php" method="post" id="process" name="process">
	<input type="hidden" name="cmd" value="_pay_simple">
	<input type="hidden" name="reset" value="1">
	<input type="hidden" name="merchant" value="<?php echo $pvs_global_settings["coinpayments_account"] ?>">
	<input type="hidden" name="currency" value="<?php echo pvs_get_currency_code(1) ?>">
	<input type="hidden" name="amountf" value="<?php echo $product_total ?>">
	<input type="hidden" name="item_name" value="<?php echo $product_name ?>">
	<input type="hidden" name="item_number" value="<?php echo($product_type . "-" . $product_id);?>">
	<input type="hidden" name="success_url" value="<?php echo (site_url( ) );?>/payment-success/">
	<input type="hidden" name="cancel_url" value="<?php echo (site_url( ) );?>/payment-fail/">
	<input type="hidden" name="ipn_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=coinpayments">
</form>
<?php
}

pvs_show_payment_page( 'footer' );
?>