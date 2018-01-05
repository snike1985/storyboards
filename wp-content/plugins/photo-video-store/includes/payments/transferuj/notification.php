<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["transferuj_active"] ) {
	exit();
}

$hash = md5( $pvs_global_settings["transferuj_account"]. $_REQUEST["tr_id"] . $_REQUEST["tr_amount"] . $_REQUEST["tr_crc"] . $pvs_global_settings["transferuj_pasword"] );

if ( $_REQUEST["tr_status"] and $hash == $_REQUEST["md5sum"] and $_SERVER["REMOTE_ADDR"] == "195.149.229.109" and $_POST['tr_error'] == "none" ) {
	$crc = explode( "-", $_REQUEST["tr_crc"] );
	$id = ( int )$crc[1];
	$product_type = pvs_result( $crc[0] );

	$transaction_id = pvs_transaction_add( "transferuj", pvs_result( $_REQUEST["tr_id"] ), $product_type, $id );

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

echo "TRUE";

?>