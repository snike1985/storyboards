<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["ccbill_active"] ) {
	$currencyCode = 840;
	if ( pvs_get_currency_code(1) == "AUD" ) {
		$currencyCode = "036";
	}
	if ( pvs_get_currency_code(1) == "CAD" ) {
		$currencyCode = 124;
	}
	if ( pvs_get_currency_code(1) == "JPY" ) {
		$currencyCode = 392;
	}
	if ( pvs_get_currency_code(1) == "GBP" ) {
		$currencyCode = 826;
	}
	if ( pvs_get_currency_code(1) == "USD" ) {
		$currencyCode = 840;
	}
	if ( pvs_get_currency_code(1) == "EUR" ) {
		$currencyCode = 978;
	}

	$url = "https://bill.ccbill.com/jpost/signup.cgi";
	if ( $pvs_global_settings["ccbill_flexform"] ) {
		$url = "https://api.ccbill.com/wap-frontflex/flexforms/" . $pvs_global_settings["ccbill_form"];
	}
?>

	<form  name="process" id="process" action="<?php echo $url ?>" method="post">	
	<input type="hidden" name="clientAccnum" value='<?php echo $pvs_global_settings["ccbill_account"] ?>'>
	<input type="hidden" name="clientSubacc" value='<?php echo $pvs_global_settings["ccbill_subaccount"] ?>'>	
	<input type="hidden" name="formName" value='<?php echo $pvs_global_settings["ccbill_form"] ?>'>	
	<input type="hidden" name="formPrice" value="<?php echo pvs_price_format( $product_total, 2 )?>"> 
	<input type="hidden" name="formPeriod" value="30"> 	
	<input type="hidden" name="initialPrice" value="<?php echo pvs_price_format( $product_total, 2 )?>"> 
	<input type="hidden" name="initialPeriod" value="30">
	<input type="hidden" name="currencyCode" value="<?php echo $currencyCode ?>"> 
	<input type="hidden" name="formDigest"  value="<?php echo md5( pvs_price_format( $product_total, 2 ) . "30" . $currencyCode . $pvs_global_settings["ccbill_password"] )?>">
	<input type="hidden" name="product_id" value="<?php echo $product_id ?>">	
	<input type="hidden" name="product_type" value="<?php echo $product_type ?>">	
	</form>

	<?php

}

pvs_show_payment_page( 'footer' );
?>