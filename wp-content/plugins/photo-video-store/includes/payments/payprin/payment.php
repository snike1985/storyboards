<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payprin_active"] ) {
	exit();
}


pvs_show_payment_page( 'header' );

$hashseed = mktime();
$hashdata = "sale" . ":" . $pvs_global_settings["payprin_password"] . ":" . pvs_price_format( $product_total,
	2 ) . ":" . $product_id . ":" . $hashseed;
$hash = md5( $hashdata );
$UMhash = "m/" . $hashseed . "/" . $hash . "/y";
?>



<form action="https://axisgwy.payprin.com/interface/epayform/" name="process" id="process" method="POST">
<input type="hidden" name="UMkey" value="<?php echo $pvs_global_settings["payprin_account"] ?>"> 
<input type="hidden" name="UMcommand" value="sale"> 
<input type="hidden" name="UMamount" value="<?php echo pvs_price_format( $product_total, 2 )?>"> 
<input type="hidden" name="UMinvoice" value="<?php echo $product_id ?>"> 
<input type="hidden" name="UMdescription" value="<?php echo $product_type ?>"> 
<input type="hidden" name="UMhash" value="<?php echo $UMhash ?>"> 
</form>

<?php

pvs_show_payment_page( 'footer' );
?>