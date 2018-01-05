<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["targetpay_active"] ) {
	exit();
}

if ( isset( $_POST['rtlo'] ) && isset( $_POST['trxid'] ) && isset( $_POST['status'] ) ) {
	if ( ( $status = CheckReturnurl( $pvs_global_settings["targetpay_account"], $_POST['trxid'] ) ) == "000000 OK" ) {
		$flag = true;
	} else {
		$flag = false;
	}

	if ( HandleReporturl( $_POST['rtlo'], $_POST['trxid'], $_POST['status'] ) and $flag ) {

		$mass = explode( "-", pvs_result( $_POST["description"] ) );
		$product_type = $mass[0];
		$id = ( int )$mass[1];
		$transaction_id = pvs_transaction_add( "targetpay", pvs_result( $_POST['trxid'] ),
			pvs_result( $product_type ), $id );

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

function CheckReturnurl( $rtlo, $trxid ) {
	$once = 1;
	$test = 0; // Set to 1 for testing as described in paragraph 1.3
	$url = "https://www.targetpay.com/ideal/check?" . "rtlo=" . $rtlo . "&trxid=" .
		$trxid . "&once=" . $once . "&test=" . $test;
	return httpGetRequest( $url );
}

function HandleReporturl( $rtlo, $trxid, $status ) {
	if ( substr( $_SERVER['REMOTE_ADDR'], 0, 10 ) == "89.184.168" || substr( $_SERVER['REMOTE_ADDR'],
		0, 9 ) == "78.152.58" ) {

		return true;
	} else {
		return false;
	}
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
?>