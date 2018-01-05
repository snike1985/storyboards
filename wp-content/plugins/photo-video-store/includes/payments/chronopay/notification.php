<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["chronopay_active"] ) {
	if ( $pvs_global_settings["chronopay_ipn"] ) {
		$sign = md5( $pvs_global_settings["chronopay_passworord"] . $_POST['customer_id'] . $_POST['transaction_id'] . $_POST['transaction_type'] . $_POST['total'] );

		if ( $sign == $_POST['sign'] and ( $_SERVER["REMOTE_ADDR"] == "207.97.254.211" or $_SERVER["REMOTE_ADDR"] == "159.255.220.140" ) )
		{
			$mass = explode( "-", pvs_result( $_POST['order_id'] ) );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			
			$transaction_id = pvs_transaction_add( "chronopay", $_POST['transaction_id'], $product_type, $product_id );

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

			echo ( "200 ОК" );
		}
	}
}
?>