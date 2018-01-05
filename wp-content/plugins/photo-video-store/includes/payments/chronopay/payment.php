<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["chronopay_active"] ) {
		$sign = md5( $pvs_global_settings["chronopay_account"] . '-' . $product_total . '-' . $pvs_global_settings["chronopay_password"] );
		$user_info = get_userdata(get_current_user_id());
		?>
		<form method="post" action="https://payments.chronopay.com/" name="process" id="process">
		<input type="hidden" name="product_id" value="<?php echo $pvs_global_settings["chronopay_account"] ?>" />
		<input type="hidden" name="product_name" value="<?php echo $product_name ?>" />
		<input type="hidden" name="product_price" value="<?php echo $product_total ?>" />
		<input type="hidden" name="product_price_currency" value="<?php echo pvs_get_currency_code(1) ?>" />

		<input type="hidden" name="f_name" value="<?php
				echo @$user_info -> first_name ?>" />
		<input type="hidden" name="s_name" value="<?php
				echo @$user_info -> last_name ?>" />
		<input type="hidden" name="street" value="<?php
				echo @$user_info -> address ?>" />
		<input type="hidden" name="city" value="<?php
				echo @$user_info -> city ?>" />
		<input type="hidden" name="state" value="<?php
				echo @$user_info -> state ?>" />
		<input type="hidden" name="zip" value="<?php
				echo @$user_info -> zipcode ?>" />
		<input type="hidden" name="country" value="<?php
				echo @$user_info -> country ?>" />
		<input type="hidden" name="phone" value="<?php
				echo @$user_info -> telephone ?>" />
		<input type="hidden" name="email" value="<?php
				echo @$user_info -> email ?>" />

		<input type="hidden" name="cb_url" value="<?php echo (site_url( ) );?>/payment-notification/?payment=chronopay" />
		<input type="hidden" name="cb_type" value="P" />
		<input type="hidden" name="success_url" value="<?php echo (site_url( ) );?>/payment-success/" />
		<input type="hidden" name="decline_url" value="<?php echo (site_url( ) );?>/payment-fail/" />
		<input type="hidden" name="order_id" value="<?php echo $product_type ?>-<?php echo $product_id ?>" />
		<input type="hidden" name="sign" value="<?php echo $sign ?>" /> 
		</form>
		<?php
}

pvs_show_payment_page( 'footer' );
?>