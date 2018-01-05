<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["segpay_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$apackage = 0;
$aproduct = 0;

if ( $_POST["tip"] == "credits" ) {
	$sql = "select * from " . PVS_DB_PREFIX . "gateway_segpay where credits=" . ( int )
		$_POST["credits"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$apackage = $ds->row["package_id"];
		$aproduct = $ds->row["product_id"];
	}
}

if ( $_POST["tip"] == "subscription" ) {
	$sql = "select * from " . PVS_DB_PREFIX . "gateway_segpay where subscription=" . ( int )
		$_POST["subscription"];
	$ds->open( $sql );
	if ( ! $ds->eof ) {
		$apackage = $ds->row["package_id"];
		$aproduct = $ds->row["product_id"];
	}
}

?>
<form  name="process" id="process" action="https://secure2.segpay.com/billing/poset.cgi" method="post">
<input type="hidden" name="x-eticketid" value="<?php echo $apackage ?>:<?php echo $aproduct ?>">
<input type="hidden" name="x-auth-link" value="<?php echo (site_url( ) );?>/payment-success/">
<input type="hidden" name="x-auth-text" value="Click here to return to the store">
<input type="hidden" name="product_id" value="<?php echo $product_id ?>"/>
<input type="hidden" name="product_type" value="<?php echo $product_type ?>"/>
</form>
<?php

pvs_show_payment_page( 'footer' );
?>