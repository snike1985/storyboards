<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["bitpay_active"] ) {
	$response = file_get_contents( "php://input" );
	
	if ( $response != '' ) {
		$results = json_decode( $response );
	
		$ch = curl_init();
	
		if ( $pvs_global_settings["bitpay_test"] ) {
			curl_setopt( $ch, CURLOPT_URL, "https://test.bitpay.com/api/invoice/" . $results->
				id );
		} else {
			curl_setopt( $ch, CURLOPT_URL, "https://bitpay.com/api/invoice/" . $results->id );
		}
	
		curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );
	
		$headers = array();
		$headers[] = "Authorization: Basic " . base64_encode( $pvs_global_settings["bitpay_account"] );
	
		curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	
		$results_status = curl_exec( $ch );
	
		if ( ! curl_errno( $ch ) ) {
			$res = json_decode( $results_status );
	
			if ( $res->status == "paid" or $res->status == "confirmed" ) {
				$crc = json_decode( $res->posData );
				$id = ( int )$crc->product_id;
				$product_type = pvs_result( $crc->product_type );
	
				$transaction_id = pvs_transaction_add( "bitpay", pvs_result( $res->id ), $product_type,
					$id );
	
				if ( $product_type == "credits" and ! pvs_is_order_approved( $id, 'credits' )  )
				{
					pvs_credits_approve( $id, $transaction_id );
					pvs_send_notification( 'credits_to_user', $id );
					pvs_send_notification( 'credits_to_admin', $id );
				}
	
				if ( $product_type == "subscription" and ! pvs_is_order_approved( $id, 'subscription' )  )
				{
					pvs_subscription_approve( $id );
					pvs_send_notification( 'subscription_to_user', $id );
					pvs_send_notification( 'subscription_to_admin', $id );
				}
	
				if ( $product_type == "order" and ! pvs_is_order_approved( $id, 'order' )  )
				{
					pvs_order_approve( $id );
					pvs_commission_add( $id );
	
					pvs_coupons_add( pvs_order_user( $id ) );
					pvs_send_notification( 'neworder_to_user', $id );
					pvs_send_notification( 'neworder_to_admin', $id );
				}
			}
		}
		curl_close( $ch );
	}
}
?>