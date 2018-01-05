<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["nochex_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );
?>
<form method="post" action="https://secure.nochex.com/"  name="process" id="process">
<input type="hidden" name="merchant_id" value="<?php echo $pvs_global_settings["nochex_active"] ?>" />
<input type="hidden" name="amount" value="<?php echo $product_total ?>" />
<input type="hidden" name="status" value="live" />
<input type="hidden" name="description" value="<?php echo $product_name ?>" /> ?>" />
<input type="hidden" name="success_url" value="<?php echo (site_url( ) );?>/payment-success/" />
<input type="hidden" name="cancel_url" value="<?php echo (site_url( ) );?>/payment-fail/" />


<?php
		$user_info = get_userdata(get_current_user_id());
?>	
<input type="hidden" name="billing_fullname" value="<?php
			echo @$user_info -> first_name . ' ' . @$user_info -> last_name ?>" />
<input type="hidden" name="billing_address" value="<?php
			echo @$user_info -> address ?>" />
<input type="hidden" name="billing_postcode" value="" />
<input type="hidden" name="delivery_fullname" value="<?php
			echo @$user_info -> first_name . ' ' . @$user_info -> last_name ?>" />
<input type="hidden" name="delivery_address" value="<?php
			echo @$user_info -> address ?>" />
<input type="hidden" name="delivery_postcode" value="" />
<input type="hidden" name="email_address" value="<?php
			echo @$user_info -> user_email ?>" />
<input type="hidden" name="customer_phone_number" value="<?php
			echo @$user_info -> telephone ?>" />
</form>

<?php
pvs_show_payment_page( 'footer' );
?>