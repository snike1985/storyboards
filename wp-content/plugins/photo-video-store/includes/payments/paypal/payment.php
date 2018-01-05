<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["paypal_active"] ) {
?>
		<form method="post" name="process" id="process" action="https://www.paypal.com/cgi-bin/webscr">
		<input type="hidden" name="rm" value="2"/>
		<?php
		if ( isset( $recurring ) and $recurring == 1 ) {
		?>
			<input type="hidden" name="cmd" value="_xclick-subscriptions">
			<input type="hidden" name="a3" value="<?php echo $product_total ?>">
			<input type="hidden" name="p3" value="<?php echo $recurring_days ?>">
			<input type="hidden" name="t3" value="D">
			<input type="hidden" name="src" value="1">
			<input type="hidden" name="sra" value="1">
		<?php
		} else {
		?>
			<input type="hidden" name="cmd" value="_xclick"/>
			<input type="hidden" name="amount" value="<?php echo $product_total ?>"/>
		<?php
		}
		?>
		<input type="hidden" name="business" value="<?php echo $pvs_global_settings["paypal_account"] ?>"/>
		<input type="hidden" name="cancel_return" value="<?php echo (site_url( ) );?>/payment-fail/"/>
		<input type="hidden" name="notify_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=paypal&<?php echo "&product_type=" . $product_type ?>"/>
		<input type="hidden" name="return" value="<?php echo (site_url( ) );?>/payment-success/"/>
		<input type="hidden" name="item_name" value="<?php echo $product_name ?>"/>
		<input type="hidden" name="item_number" value="<?php echo $product_id ?>"/>
		<input type="hidden" name="currency_code" value="<?php echo pvs_get_currency_code(1)?>"/>
		</form>
		<?php
}

pvs_show_payment_page( 'footer' );
?>