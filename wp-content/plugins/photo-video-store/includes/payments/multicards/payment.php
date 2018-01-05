<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["multicards_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );
?>
<form method="post" name="process" id="process" action="https://secure.multicards.com/cgi-bin/order2/processorder1.pl">
<input type=hidden name="mer_id" value="<?php echo $pvs_global_settings["multicards_account"] ?>">
<input type=hidden name="num_items" value="1">
<input type=hidden name="mer_url_idx" value="<?php echo $pvs_global_settings["multicards_account2"] ?>">
<input type=hidden name="item1_desc" value="<?php echo $product_type ?>">
<input type=hidden name="item1_price" value="<?php echo $product_total ?>">
<input type=hidden name="item1_qty" value="1">
<input type=hidden name="user1" value="<?php echo $product_id ?>">
</form>
<?php
pvs_show_payment_page( 'footer' );
?>