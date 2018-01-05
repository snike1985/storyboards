<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["targetpay_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

function StartTransaction( $rtlo, $bank, $description, $amount, $returnurl, $reporturl ) {
	$url = "https://www.targetpay.com/ideal/start?" . "rtlo=" . $rtlo . "&bank=" . $bank .
		"&description=" . urlencode( $description ) . "&amount=" . $amount .
		"&returnurl=" . urlencode( $returnurl ) . "&reporturl=" . urlencode( $reporturl );
	$strResponse = httpGetRequest( $url );
	$aResponse = explode( '|', $strResponse );

	if ( ! isset( $aResponse[1] ) )
		die( 'Error' . $aResponse[0] );
	$responsetype = explode( ' ', $aResponse[0] );
	$trxid = $responsetype[1];

	if ( $responsetype[0] == "000000" )
		return $aResponse[1];
	else
		die( $aResponse[0] );
}

function httpGetRequest( $url ) {
	$ch = curl_init( $url );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	$strResponse = curl_exec( $ch );
	curl_close( $ch );
	if ( $strResponse === false )
		die( "Could not fetch response " . $url );
	return $strResponse;
}

$rtlo = $pvs_global_settings["targetpay_account"];
$bank = pvs_result( $_REQUEST["bank"] );
$description = $product_type . "-" . $product_id;
$amount = $product_total * 100;
$returnurl = site_url( ) . "/payment-success/";
$reporturl = site_url( ) . "/payment-notification/?payment=targetpay";

$url = StartTransaction( $rtlo, $bank, $description, $amount, $returnurl, $reporturl );

?>
<form method="post" action="<?php echo($url);?>"  name="process" id="process">
</form>
<?php
pvs_show_payment_page( 'footer' );
?>