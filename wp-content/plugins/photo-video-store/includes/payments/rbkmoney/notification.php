<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["rbkmoney_active"] ) {
	exit();
}

if ( $_POST ) {
	header( "HTTP/1.0 200 OK" );

	$eshopId = trim( stripslashes( $_POST['eshopId'] ) );
	$orderId = trim( stripslashes( $_POST['orderId'] ) );
	$serviceName = trim( stripslashes( $_POST['serviceName'] ) );
	$eshopAccount = trim( stripslashes( $_POST['eshopAccount'] ) );
	$recipientAmount = trim( stripslashes( $_POST['recipientAmount'] ) );
	$recipientCurrency = trim( stripslashes( $_POST['recipientCurrency'] ) );
	$paymentStatus = trim( stripslashes( $_POST['paymentStatus'] ) );
	$userName = trim( stripslashes( $_POST['userName'] ) );
	$userEmail = trim( stripslashes( $_POST['userEmail'] ) );
	$paymentData = trim( stripslashes( $_POST['paymentData'] ) );
	$secretKey = trim( stripslashes( $_POST['secretKey'] ) );
	$hash = trim( stripslashes( $_POST['hash'] ) );

	$control_hash = strtolower( md5( $eshopId . "::" . $orderId . "::" . $serviceName .
		"::" . $eshopAccount . "::" . $recipientAmount . "::" . $recipientCurrency .
		"::" . $paymentStatus . "::" . $userName . "::" . $userEmail . "::" . $paymentData .
		"::" . $pvs_global_settings["rbkmoney_password"] ) );

	if ( $hash == $control_hash ) {
		if ( $paymentStatus == 5 ) {
			$rbk = explode( "-", $orderId );
			$product_type = $rbk[0];
			$id = ( int )$rbk[1];
			$transaction_id = pvs_transaction_add( "rbkmoney", ( int )$_POST["paymentId"],
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
}
?>