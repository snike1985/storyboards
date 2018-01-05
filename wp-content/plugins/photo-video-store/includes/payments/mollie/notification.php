<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["mollie_active"] ) {
	exit();
}

if ( $_POST ) {
	try
	{
		$api_key = $pvs_global_settings["mollie_account"] ;
		include PVS_PATH . "includes/plugins/mollie/examples/initialize.php";

		$payment = $mollie->payments->get( $_POST["id"] );
		$order_id = $payment->metadata->order_id;

		if ( $payment->isPaid() == TRUE ) {
			$mass = explode( "-", $order_id );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			$transaction_id = pvs_transaction_add( "mollie", "", pvs_result( $product_type ),
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
	catch ( Mollie_API_Exception $e ) {
		echo "API call failed: " . htmlspecialchars( $e->getMessage() );
	}
}
?>