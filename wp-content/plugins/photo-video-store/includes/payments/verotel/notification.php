<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["verotel_active"] ) {
	exit();
}

include ( PVS_PATH . "includes/plugins/verotel/FlexPay.php" );

$signature_check = FlexPay::validate_signature( $pvs_global_settings["verotel_password"], $_REQUEST );

if ( $signature_check ) {
	$crc = explode( "-", $_REQUEST["referenceID"] );
	$id = ( int )$crc[1];
	$product_type = pvs_result( $crc[0] );

	$transaction_id = pvs_transaction_add( "verotel", pvs_result( $_REQUEST["SaleID"] ),
		$product_type, $id );

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

echo "OK";
?>