<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["epay_active"] and $pvs_global_settings["epay_ipn"] ) {
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

	$ENCODED = $_POST['encoded'];
	$CHECKSUM = $_POST['checksum'];

	# XXX Secret word with which merchant make CHECKSUM on the ENCODED packet
	$hmac = hmac( 'sha1', $ENCODED, $secret ); # XXX SHA-1 algorithm REQUIRED

	//$response = "VERIFIED";
	if ( $hmac == $CHECKSUM )
	{

		$data = base64_decode( $ENCODED );
		$lines_arr = split( "\n", $data );
		$info_data = '';

		foreach ( $lines_arr as $line )
		{
			if ( preg_match( "/^INVOICE=(\d+):STATUS=(PAID|DENIED|EXPIRED)(:PAY_TIME=(\d+):STAN=(\d+):BCODE=([0-9a-zA-Z]+))?$/",
				$line, $regs ) )
			{
				$invoice = $regs[1];
				$status = $regs[2];
				$pay_date = $regs[4]; # XXX if PAID
				$stan = $regs[5]; # XXX if PAID
				$bcode = $regs[6]; # XXX if PAID

				$info_data .= "INVOICE=$invoice:STATUS=OK\n";

			}
		}
		echo $info_data, "\n";

		if ( isset( $invoice ) and $status == 'PAID' )
		{
			$prod = explode( "-", $invoice );
			$id = ( int )$prod[1];
			$desc = $prod[0];

			$transaction_id = pvs_transaction_add( "epay", "", $product_type, $id );
		
			if ( $product_type == "credits" and ! pvs_is_order_approved( $id, 'credits' ) ) {
				pvs_credits_approve( $id, $transaction_id );
				pvs_send_notification( 'credits_to_user', $id );
				pvs_send_notification( 'credits_to_admin', $id );
			}
		
			if ( $product_type == "subscription" and ! pvs_is_order_approved( $id, 'subscription' ) ) {
				pvs_subscription_approve( $id );
				pvs_send_notification( 'subscription_to_user', $id );
				pvs_send_notification( 'subscription_to_admin', $id );
			}
		
			if ( $product_type == "order"  and ! pvs_is_order_approved( $id, 'order' ) ) {
				pvs_order_approve( $id );
				pvs_commission_add( $id );
		
				pvs_coupons_add( pvs_order_user( $id ) );
				pvs_send_notification( 'neworder_to_user', $id );
				pvs_send_notification( 'neworder_to_admin', $id );
			}
		}
	} else
	{
		echo "ERR=Not valid CHECKSUM\n";
	}
}
?>