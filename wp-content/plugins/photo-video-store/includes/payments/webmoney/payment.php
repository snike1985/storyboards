<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["webmoney_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

?>

<form method="POST" action="https://merchant.webmoney.ru/lmi/payment.asp" name="process" id="process">
	<input type="hidden" name="LMI_PAYMENT_AMOUNT" value="<?php echo pvs_price_format( $product_total, 2 )?>">
	<input type="hidden" name="LMI_PAYMENT_DESC" value="<?php echo $product_name ?>">
	<input type="hidden" name="LMI_PAYMENT_NO" value="<?php echo $product_id ?>">
	<input type="hidden" name="LMI_PAYEE_PURSE" value="<?php echo $pvs_global_settings["webmoney_account"] ?>">
	<input type="hidden" name="ptype" value="<?php echo $product_type ?>">
</form>

<?php

pvs_show_payment_page( 'footer' );
?>