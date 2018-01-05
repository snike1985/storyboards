<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

$secret = $pvs_global_settings["epay_password"];

function hmac( $algo, $data, $passwd ) {
	/* md5 and sha1 only */
	$algo = strtolower( $algo );
	$p = array( 'md5' => 'H32', 'sha1' => 'H40' );
	if ( strlen( $passwd ) > 64 )
		$passwd = pack( $p[$algo], $algo( $passwd ) );
	if ( strlen( $passwd ) < 64 )
		$passwd = str_pad( $passwd, 64, chr( 0 ) );

	$ipad = substr( $passwd, 0, 64 ) ^ str_repeat( chr( 0x36 ), 64 );
	$opad = substr( $passwd, 0, 64 ) ^ str_repeat( chr( 0x5C ), 64 );

	return ( $algo( $opad . pack( $p[$algo], $algo( $ipad . $data ) ) ) );
}


if ( $pvs_global_settings["epay_active"] ) {
	$submit_url = "https://www.epay.bg";
	//$submit_url = "https://devep2.datamax.bg/ep2/epay2_demo/";

	$min = $pvs_global_settings["epay_account"];
	$invoice    = $product_type."-".$product_id; # XXX Invoice
	$sum = pvs_price_format( $product_total, 2 ); # XXX Ammount
	$exp_date = '01.08.2020'; # XXX Expiration date
	$descr = $product_name; # XXX Description

	$data = <<< DATA
MIN={$min}
INVOICE={$invoice}
AMOUNT={$sum}
EXP_TIME={$exp_date}
DESCR={$descr}
DATA;

	# XXX Packet:
	#     (MIN or EMAIL)=     REQUIRED
	#     INVOICE=            REQUIRED
	#     AMOUNT=             REQUIRED
	#     EXP_TIME=           REQUIRED
	#     DESCR=              OPTIONAL

	$ENCODED = base64_encode( $data );
	$CHECKSUM = hmac( 'sha1', $ENCODED, $pvs_global_settings["epay_password"] ); # XXX SHA-1 algorithm REQUIRED

	?>
	<form method="post" name="process" id="process" action="<?php echo $submit_url ?>">
	<input type=hidden name=PAGE value="paylogin">
	<input type=hidden name=ENCODED value="<?php echo $ENCODED ?>">
	<input type=hidden name=CHECKSUM value="<?php echo $CHECKSUM ?>">
	<input type=hidden name=CURRENCY value="<?php echo pvs_get_currency_code(1) ?>">
	<input type=hidden name=URL_OK value="<?php echo (site_url( ) );?>/payment-success/">
	<input type=hidden name=URL_CANCEL value="<?php echo (site_url( ) );?>/payment-fail/">
	</form>
	<?php
}

pvs_show_payment_page( 'footer' );
?>