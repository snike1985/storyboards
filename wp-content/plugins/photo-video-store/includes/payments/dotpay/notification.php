<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["dotpay_active"] ) {
	echo "OK";
	
	if ( $_POST ) {
		$PIN = $pvs_global_settings["dotpay_password"];
		$sign = $PIN . $_POST['id'] . $_POST['operation_number'] . $_POST['operation_type'] .
			$_POST['operation_status'] . $_POST['operation_amount'] . $_POST['operation_currency'] .
			$_POST['operation_original_amount'] . $_POST['operation_original_currency'] . $_POST['operation_datetime'] .
			$_POST['control'] . $_POST['description'] . $_POST['email'] . $_POST['p_info'] .
			$_POST['p_email'] . $_POST['channel'];
	
		$ip = $_SERVER['REMOTE_ADDR'];
		$dotpay_ip = "195.150.9.37";
	
		if ( hash( 'sha256', $sign ) == $_POST['signature'] and $pvs_global_settings["dotpay_account"] ==
			$_POST['id'] and $ip == $dotpay_ip ) {
	
			if ( $_POST["operation_status"] == "completed" ) {
				$mass = explode( "-", pvs_result( $_POST["description"] ) );
				$product_type = $mass[0];
				$id = ( int )$mass[1];
				$transaction_id = pvs_transaction_add( "dotpay", pvs_result( $_POST["operation_number"] ),
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
}
?>