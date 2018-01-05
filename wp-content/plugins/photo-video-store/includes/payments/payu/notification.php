<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payu_active"] ) {
	exit();
}

if ( $_POST ) {
	$sig = md5( $pvs_global_settings["payu_account"]  . $_POST["session_id"] . $_POST["ts"] . $pvs_global_settings["payu_password2"]  );

	$sig2 = md5( $pvs_global_settings["payu_account"]  . $_POST["session_id"] . $_POST["ts"] . $pvs_global_settings["payu_password"]  );

	echo ( "OK" );

	if ( $sig == $_POST["sig"] ) {

		$postdata = "pos_id=" . $pvs_global_settings["payu_account"] . "&session_id=" . $_POST["session_id"] .
			"&ts=" . $_POST["ts"] . "&sig=" . $sig2;

		$curl = curl_init( "https://secure.payu.com/paygw/UTF/Payment/get" );

		curl_setopt( $curl, CURLOPT_HEADER, 0 );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $postdata );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 1 );
		/*
		curl_setopt($ch, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1);
		curl_setopt($ch, CURLOPT_POST, 1);
		curl_setopt($ch, CURLOPT_RETURNTRANSFER,1);
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postdata);
		curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, 1);
		curl_setopt($ch, CURLOPT_SSL_VERIFYHOST, 2);
		curl_setopt($ch, CURLOPT_FORBID_REUSE, 1);
		curl_setopt($ch, CURLOPT_HTTPHEADER, array('Connection: Close')); 
		*/
		$response = curl_exec( $curl );
		curl_close( $curl );
		//echo($response);

		if ( preg_match( "/trans_status:99/", $response ) or preg_match( "/<status>99<\/status>/",
			$response ) ) {
			$mass = explode( "-", pvs_result( $_POST["session_id"] ) );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			$transaction_id = pvs_transaction_add( "payu", "", pvs_result( $product_type ),
				$id );

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
	}
}
?>