<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paygate_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());

include ( PVS_PATH . 'includes/plugins/paygate/paygate.payweb3.php' );

$mandatoryFields = array(
	'PAYGATE_ID' => $pvs_global_settings["paygate_account"],
	'REFERENCE' => $product_type . "-" . $product_id,
	'AMOUNT' => round( $product_total * 100 ),
	'CURRENCY' => pvs_get_currency_code(1),
	'RETURN_URL' => site_url( ) . "/payment-success/",
	'TRANSACTION_DATE' => date( 'Y-m-d H:i:s' ),
	'LOCALE' => 'en-za',
	'COUNTRY' => 'ZAF',
	'EMAIL' => @$user_info -> user_email );

$optionalFields = array(
	'PAY_METHOD' => '',
	'PAY_METHOD_DETAIL' => '',
	'NOTIFY_URL' => site_url( ) . "/payment-notification/?payment=paygate",
	'USER1' => '',
	'USER2' => '',
	'USER3' => '',
	'VAULT' => '',
	'VAULT_ID' => '' );

$data = array_merge( $mandatoryFields, $optionalFields );

$encryption_key = $pvs_global_settings["paygate_password"];

/*
* Initiate the PayWeb 3 helper class
*/
$PayWeb3 = new PayGate_PayWeb3();
/*
* if debug is set to true, the curl request and result as well as the calculated checksum source will be logged to the php error log
*/
//$PayWeb3->setDebug(true);
/*
* Set the encryption key of your PayGate PayWeb3 configuration
*/
$PayWeb3->setEncryptionKey( $encryption_key );
/*
* Set the array of fields to be posted to PayGate
*/
$PayWeb3->setInitiateRequest( $data );

/*
* Do the curl post to PayGate
*/
$returnData = $PayWeb3->doInitiate();
?>


<form action="<?php echo($PayWeb3::$process_url) ; ?>" method="post" name="process" id="process">


<?php
if ( ! isset( $PayWeb3->lastError ) ) {
	$isValid = $PayWeb3->validateChecksum( $PayWeb3->initiateResponse );

	if ( $isValid ) {
		foreach ( $PayWeb3->processRequest as $key => $value ) {
			echo <<< HTML
<input type="hidden" name="{$key}" value="{$value}" />
HTML;
		}
	} else {
		echo 'Checksums do not match';
	}
}
?>

	</form>
<?php
pvs_show_payment_page( 'footer' );
?>