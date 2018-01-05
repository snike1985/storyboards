<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payu_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());
?>
	<form action="https://secure.payu.com/paygw/UTF/NewPayment" method="POST" name="process" id="process">
	<input type="hidden" name="first_name" value="<?php echo @$user_info -> first_name ?>">
	<input type="hidden" name="email" value="<?php echo @$user_info -> user_email ?>">
	<input type="hidden" name="last_name" value="<?php echo @$user_info -> last_name ?>">
	<?php

	$ts = pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
		date( "Y" ) );

	$sig = md5( $pvs_global_settings["payu_account"] . "" . $product_type . "-" . $product_id . $pvs_global_settings["payu_password3"] .
		( $product_total * 100 ) . $product_name . "" . "" . $product_id .  @$user_info -> first_name .
		 @$user_info -> last_name . "" . "" . "" . "" . "" . "" .  @$user_info -> user_email . "" . "" .
		$_SERVER["REMOTE_ADDR"] . $ts . $pvs_global_settings["payu_password"] );?>
	<input type="hidden" name="sig" value="<?php echo $sig ?>">
	<input type="hidden" name="ts" value="<?php echo $ts ?>">
    <input type="hidden" name="pos_id" value="<?php echo $pvs_global_settings["payu_account"] ?>">
    <input type="hidden" name="pos_auth_key" value="<?php echo $pvs_global_settings["payu_password3"] ?>">
    <input type="hidden" name="session_id" value="<?php echo $product_type ?>-<?php echo $product_id ?>">
     <input type="hidden" name="order_id" value="<?php echo $product_id ?>">
    <input type="hidden" name="amount" value="<?php echo ( $product_total * 100 )?>">
    <input type="hidden" name="desc" value="<?php echo $product_name ?>">
    <input type="hidden" name="client_ip" value="<?php echo $_SERVER["REMOTE_ADDR"] ?>">
    <input type="hidden" name="js" value="0">
	</form>
	<?php

pvs_show_payment_page( 'footer' );
?>