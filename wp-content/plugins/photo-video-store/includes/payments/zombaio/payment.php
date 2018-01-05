<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["zombaio_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

?>
<form method="post" name="process" id="process" action="https://secure.zombaio.com/?<?php echo $pvs_global_settings["zombaio_account"] ?>.<?php echo $pvs_global_settings["zombaio_account2"] ?>.US">
<input type="hidden" name="identifier" value="<?php echo $product_id ?>">
<input type="hidden" name="approve_url" value="<?php echo (site_url( ) );?>/payment-success/">
<input type="hidden" name="decline_url" value="<?php echo (site_url( ) );?>/payment-fail/">
<input type="hidden" name="DynAmount_Value" value="<?php echo pvs_price_format( $product_total, 2 )?>">
<input type="hidden" name="DynAmount_Hash" value="<?php echo md5( $pvs_global_settings["zombaio_password"] . pvs_price_format( $product_total, 2 ) )?>">
<?php
	$sql = "select quantity from " . PVS_DB_PREFIX . "credits_list where id_parent=" . ( int )
		$product_id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
?>
	<input type="hidden" name="credit_value" value="<?php echo $rs->row["quantity"] ?>">
	<?php
	}
?>
</form> 
<?php

pvs_show_payment_page( 'footer' );
?>