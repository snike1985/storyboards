<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["alertpay_active"] ) {
	?>
	<form method="post" name="process" id="process" action="https://secure.payza.com/checkout">
	<input type="hidden" name="ap_purchasetype" value="item"/>
	<input type="hidden" name="ap_merchant" value="<?php echo $pvs_global_settings["alertpay_account"] ?>"/>
	<input type="hidden" name="ap_itemname" value="<?php echo $product_name
	?>"/>
	<input type="hidden" name="ap_currency" value="<?php echo pvs_get_currency_code(1)
	?>"/>
	<input type="hidden" name="ap_returnurl" value="<?php echo (site_url( ) );?>/payment-success/"/>
	<input type="hidden" name="ap_itemcode" value="<?php echo $product_id
	?>"/>
	<input type="hidden" name="ap_quantity" value="1"/>
	<input type="hidden" name="ap_description" value="<?php echo $product_type
	?>"/>
	<input type="hidden" name="ap_amount" value="<?php echo $product_total
	?>"/>
	<input type="hidden" name="ap_cancelurl" value="<?php echo (site_url( ) );?>/payment-fail/"/>
	</form>
	<?php
}

pvs_show_payment_page( 'footer' );
?>