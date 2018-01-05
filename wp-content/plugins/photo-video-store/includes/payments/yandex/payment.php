<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["yandex_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());

if ( ! $pvs_global_settings["yandex_test"] ) {
?>
<form action="https://money.yandex.ru/eshop.xml" method="post" name="process" id="process">
<?php
	} else {
?>
<form action="https://demomoney.yandex.ru/eshop.xml" method="post" name="process" id="process">
<?php
	}
?>
<input name="shopId" value="<?php echo $pvs_global_settings["yandex_account"] ?>" type="hidden"/>
<input name="scid" value="<?php echo $pvs_global_settings["yandex_account2"] ?>" type="hidden"/>
<input name="sum" value="<?php echo pvs_price_format( $product_total, 2 )?>" type="hidden">
<input name="customerNumber" value="<?php echo @$user_info -> user_login ?>" type="hidden"/>
<input name="paymentType" value="<?php echo pvs_result( $_REQUEST["yandex_payments"] )?>" type="hidden"/>
<input name="orderNumber" value="<?php echo $product_type ?>-<?php echo $product_id ?>" type="hidden"/>
<input name="cps_email" value="<?php echo @$user_info -> user_email ?>" type="hidden"/>
</form> 



<?php
pvs_show_payment_page( 'footer' );
?>