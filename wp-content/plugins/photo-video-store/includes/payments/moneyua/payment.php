<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["moneyua_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$strxml = "<?php xml version=\"1.0\" encoding=\"UTF-8\"?>
<MAIN>
<PAYMENT_AMOUNT>" . ( $product_total * 100 ) . "</PAYMENT_AMOUNT>
<PAYMENT_INFO>" . $product_name . "</PAYMENT_INFO>
<PAYMENT_DELIVER></PAYMENT_DELIVER>
<PAYMENT_ADDVALUE></PAYMENT_ADDVALUE>
<PAYMENT_ORDER>" . $product_type . "-" . $product_id . "</PAYMENT_ORDER>
<PAYMENT_TYPE>" . pvs_result( $_REQUEST["moneyua_method"] ) .
	"</PAYMENT_TYPE>
<PAYMENT_RULE>" . ( $pvs_global_settings["moneyua_commission"] + 1 ) . "</PAYMENT_RULE>
<PAYMENT_VISA></PAYMENT_VISA>
<PAYMENT_RETURNRES>" . site_url( ) .
	"/payment-notification/?payment=moneyua</PAYMENT_RETURNRES>
<PAYMENT_RETURN>" . site_url( ) .
	"/payment-success/</PAYMENT_RETURN>
<PAYMENT_RETURNMET>2</PAYMENT_RETURNMET>
<PAYMENT_RETURNFAIL>" . site_url( ) .
	"/payment-fail/</PAYMENT_RETURNFAIL>
<PAYMENT_TESTMODE>" . $pvs_global_settings["moneyua_test"] . "</PAYMENT_TESTMODE>
<PAYMENT_CODING>1</PAYMENT_CODING>
</MAIN>";

$strxml = base64_encode( rawurlencode( $strxml ) );

$hash = md5( $strxml . $pvs_global_settings["moneyua_password"] );?>
	<form action="http://money.ua/sale.php" name="process" id="process" method="post">
		<input type="hidden" name="flagxml" value="1">
		<input type="hidden" name="strxml" value="<?php echo $strxml ?>">
		<input type="hidden" name="MERCHANT_INFO" value="<?php echo $pvs_global_settings["moneyua_account"] ?>">
		<input type="hidden" name="PAYMENT_HASH" value="<?php echo $hash ?>">
		<input type="hidden" name="coding" value="1">
	</form>
<?php


pvs_show_payment_page( 'footer' );
?>