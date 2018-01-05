<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["worldpay_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());
?>
<form method="post" action="https://select.worldpay.com/wcc/purchase" name="process" id="process"> 
	 <input type=hidden name=instId value="<?php echo $pvs_global_settings["worldpay_account"] ?>">
	 <input type=hidden name=cartId value="<?php echo $product_id ?>">
	 <input type=hidden name=amount value="<?php echo $product_total ?>">
	 <input type=hidden name=currency value="<?php echo pvs_get_currency_code(1) ?>">
	 <input type=hidden name=testMode value="N">
	 <input type=hidden name=name value="<?php echo @$user_info -> first_name ?>">
	 <input type=hidden name=tel value="<?php echo @$user_info -> telephone ?>">
	 <input type=hidden name=email value="<?php echo @$user_info -> user_email ?>">
	 <input type=hidden name=address value="<?php echo @$user_info -> address ?>">
	 <input type=hidden name=country value="<?php echo @$user_info -> country ?>">
	 <input type=hidden name=MC_csid value="<?php echo $product_id ?>">
</form>

<?php
pvs_show_payment_page( 'footer' );
?>