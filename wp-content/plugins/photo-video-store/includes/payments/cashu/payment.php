<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["cashu_active"] ) {

	$user_info = get_userdata(get_current_user_id());
	
	$token = md5( $pvs_global_settings["cashu_account"] . ":" . pvs_price_format( $product_total, 2 ) . ":" . strtolower( pvs_get_currency_code(1) ) . ":" . $pvs_global_settings["cashu_password"] );
?>
	<form method="post" name="process" id="process" action="https://www.cashu.com/cgi-bin/pcashu.cgi">
	<input type="hidden" name="merchant_id" value="<?php echo $pvs_global_settings["cashu_account"] ?>">
	<input type="hidden" name="token" value="<?php echo $token
	?>">
	<input type="hidden" name="display_text" value="<?php echo $product_name
	?>">
	<input type="hidden" name="currency" value="<?php echo pvs_get_currency_code(1)
	?>">
	<input type="hidden" name="amount" value="<?php echo pvs_price_format( $product_total, 2 )?>">
	<input type="hidden" name="language" value="en">
	<input type="hidden" name="email" value="<?php echo @$user_info -> user_email ?>">
	<input type="hidden" name="txt1" value="<?php echo $product_type
	?>">
	<input type="hidden" name="txt2" value="<?php echo $product_id
	?>">
	</form>
<?php
}

pvs_show_payment_page( 'footer' );
?>