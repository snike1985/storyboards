<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paxum_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );
?>
		<form action="https://www.paxum.com/payment/phrame.php?action=displayProcessPaymentLogin" method="post"  name="process" id="process">
			<input type="hidden" name="business_email" value="<?php echo $pvs_global_settings["paxum_account"] ?>" />
			<input type="hidden" name="button_type_id" value="1" />
			<input type="hidden" name="item_id" value="<?php echo $product_type ?>-<?php echo $product_id ?>" />
			<input type="hidden" name="item_name" value="<?php echo $product_name ?>" />
			<input type="hidden" name="amount" value="<?php echo pvs_price_format( $product_total, 2 )?>" />
			<input type="hidden" name="currency" value="<?php echo pvs_get_currency_code(1)?>" />
			<input type="hidden" name="ask_shipping" value="1" />
			<input type="hidden" name="cancel_url" value="<?php echo (site_url( ) );?>/payment-fail/" />
			<input type="hidden" name="finish_url" value="<?php echo (site_url( ) );?>/payment-success/" />
			<input type="hidden" name="variables" value="notify_url=<?php echo (site_url( ) );?>/payment-notification/?payment=paxum" />
		</form>
<?php
pvs_show_payment_page( 'footer' );
?>