<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["victoriabank_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

function P_SIGN_ENCRYPT( $OrderId, $Timestamp, $trtType, $Amount ) {
	$MAC = '';
	$RSA_KeyPath = PVS_PATH . 'includes/plugins/victoriabank/key.pem';
	$RSA_Key = file_get_contents( $RSA_KeyPath );
	$Data = array(
		'ORDER' => $OrderId,
		'NONCE' => '11111111000000011111',
		'TIMESTAMP' => $Timestamp,
		'TRTYPE' => $trtType,
		'AMOUNT' => $Amount );

	if ( ! $RSA_KeyResource = openssl_get_privatekey( $RSA_Key ) )
		die( 'Failed get private key' );
	$RSA_KeyDetails = openssl_pkey_get_details( $RSA_KeyResource );
	$RSA_KeyLength = $RSA_KeyDetails['bits'] / 8;

	foreach ( $Data as $Id => $Filed )
		$MAC .= strlen( $Filed ) . $Filed;

	$First = '0001';
	$Prefix = '003020300C06082A864886F70D020505000410';
	$MD5_Hash = md5( $MAC );
	$Data = $First;

	$paddingLength = $RSA_KeyLength - strlen( $MD5_Hash ) / 2 - strlen( $Prefix ) /
		2 - strlen( $First ) / 2;
	for ( $i = 0; $i < $paddingLength; $i++ )
		$Data .= "FF";

	$Data .= $Prefix . $MD5_Hash;
	$BIN = pack( "H*", $Data );

	if ( ! openssl_private_encrypt( $BIN, $EncryptedBIN, $RSA_Key,
		OPENSSL_NO_PADDING ) ) {
		while ( $msg = openssl_error_string() )
			echo $msg . "<br />\n";
		die( 'Failed encrypt' );
	}

	$P_SIGN = bin2hex( $EncryptedBIN );

	return strtoupper( $P_SIGN );
}

$order_number = $product_id;
if ( $product_type == "order" ) {
	$order_number = "100" . $product_id;
}
if ( $product_type == "credits" ) {
	$order_number = "101" . $product_id;
}
if ( $product_type == "subscription" ) {
	$order_number = "102" . $product_id;
}

$timestamp = date( "Y" ) . date( "m" ) . date( "d" ) . date( "H" ) . date( "i" ) . date( "s" );

$user_info = get_userdata(get_current_user_id());
?>
<form action="https://egateway.victoriabank.md/cgi-bin/cgi_link?" method="post" id="process" name="process">
<input type="hidden" value="<?php echo $product_total ?>" name="AMOUNT" />
<input type="hidden" value="<?php echo pvs_get_currency_code(1) ?>" name="CURRENCY" />
<input type="hidden" value="<?php echo $order_number ?>" name="ORDER" />
<input type="hidden" value="<?php echo $product_name ?>" name="DESC" />
<input type="hidden" value="<?php echo $pvs_global_settings["site_name"] ?>" name="MERCH_NAME" />
<input type="hidden" value="<?php echo site_url( ) ?>" name="MERCH_URL" />
<input type="hidden" value="<?php echo $pvs_global_settings["victoriabank_account2"] ?>" name="MERCHANT" />
<input type="hidden" value="<?php echo $pvs_global_settings["victoriabank_account"] ?>" name="TERMINAL" />
<input type="hidden" value="<?php echo @$user_info -> user_email ?>" name="EMAIL" />
<input type="hidden" value="0" name="TRTYPE" />
<input type="hidden" value="md" name="COUNTRY" />
<input type="hidden" value="11111111000000011111" name="NONCE" />
<input type="hidden" value="<?php echo (site_url( ) );?>/payment-success/" name="BACKREF" />
<input type="hidden" value="2" name="MERCH_GMT" />
<input type="hidden" value="<?php echo $timestamp ?>" name="TIMESTAMP" />
<input type="hidden" value="<?php echo P_SIGN_ENCRYPT( $order_number, $timestamp, 0, $product_total )?>" name="P_SIGN" />
<input type="hidden" value="en" name="LANG" />
<input type="hidden" value="<?php echo $pvs_global_settings["company_address"] ?>" name="MERCH_ADDRESS" />
</form>
<?php
pvs_show_payment_page( 'footer' );
?>