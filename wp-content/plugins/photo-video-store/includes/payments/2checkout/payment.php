<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["2checkout_active"] ) {
?>
	<form action="https://www2.2checkout.com/2co/buyer/purchase" method="POST"  name="process" id="process">
		<input type="hidden" name="sid" value="<?php echo $pvs_global_settings["2checkout_account"] ?>">
		<input type="hidden" name="total" value="<?php echo $product_total ?>">
		<input type="hidden" name="cart_order_id" value="<?php echo $product_id ?>">
		<input type="hidden" name="product_type" value="<?php echo $product_type ?>">
		
		<input type="hidden" name="c_prod" value="<?php echo $product_id ?>">
		<input type="hidden" name="c_name" value="<?php echo $product_name ?>">
		<input type="hidden" name="c_price" value="<?php echo $product_total ?>">
	
		<input type="hidden" name="fixed" value="Y">
		<input type="hidden" name="id_type" value="1">
		<input type="hidden" name="sh_cost" value="0">
		<input type="hidden" name="demo" value="N">
		<input type="hidden" name="payment" value="2checkout">
	</form>
<?php
}

pvs_show_payment_page( 'footer' );
?>