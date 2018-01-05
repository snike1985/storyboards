<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["skrill_active"] ) {
	exit();
}

if ( ! $pvs_global_settings["skrill_ipn"] ) {
	exit();
}

$hash = strtoupper( md5( $_POST['merchant_id'] . $_POST["transaction_id"] .
				strtoupper( md5( $pvs_global_settings["skrill_password"] ) ) . $_POST['mb_amount'] . $_POST['mb_currency'] .
				$_POST['status'] ) );

if ( $hash != $_POST['md5sig'] )
{
	exit();
}

if ( $_POST["status"] == "2" )
{
	$mass = explode( "-", $_POST['order_id'] );
	$product_type = $mass[0];
	$id = ( int )$mass[1];
	
	$transaction_id = pvs_transaction_add( "skrill", $_POST["mb_transaction_id"], $product_type, $id );

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
?>