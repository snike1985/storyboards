<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["enets_active"] ) {
?>
<form method="post" action="https://www.enetspayments.com.sg/masterMerchant/collectionPage.jsp"  name="process" id="process"> 
	<input type="hidden" name="txnRef" value="<?php echo $product_id ?>"> 
	<input type="hidden" name="mid" value="<?php echo $pvs_global_settings["enets_account"] ?>"> 
	<input type="hidden" name="amount" value="<?php echo $product_total ?>">
</form>
<?php
}

pvs_show_payment_page( 'footer' );
?>