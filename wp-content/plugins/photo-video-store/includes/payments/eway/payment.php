<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["eway_active"] ) {
?>
<form method="post" action="https://www.eway.com.au/gateway/payment.asp"  name="process" id="process"> 
	<input type="hidden" name="ewayCustomerID" value="<?php echo $pvs_global_settings["eway_account"] ?>" />
	<input type="hidden" name="ewayTotalAmount" value="<?php echo ( $product_total * 100 )?>" />
	<input type="hidden" name="ewayCustomerInvoiceRef" value="<?php echo $product_id ?>" />
	<input type="hidden" name="eWAYoption1" value="<?php echo $product_type ?>" />
	<input type="hidden" name="eWAYoption2" value="<?php echo $product_id ?>" />
	<?php
		$user_info = get_userdata(get_current_user_id());
	?>
	<input type="hidden" name="ewayCustomerFirstName" value="<?php
			echo @$user_info -> first_name ?>" />
	<input type="hidden" name="ewayCustomerLastName" value="<?php
			echo @$user_info -> last_name ?>" />
	<input type="hidden" name="ewayCustomerEmail" value="<?php
			echo @$user_info -> user_email ?>" />
	<input type="hidden" name="ewayCustomerAddress" value="<?php
			echo @$user_info -> address ?>" />
	<input type="hidden" name="ewayCustomerPostcode" value="" />

	<input type="hidden" name="ewayOption3" value="false" />
	<input type="hidden" name="ewayURL" value="<?php echo (site_url( ) );?>/payment-notification/?payment=eway" />

</form>

<?php
}

pvs_show_payment_page( 'footer' );
?>