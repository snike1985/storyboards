<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paxum_active"] ) {
	exit();
}

// Getting Raw POST Data
$rawPostedData = file_get_contents( 'php://input' );

// Extracting Field=Value Pairs
$i = strpos( $rawPostedData, "&key=" );
$fieldValuePairsData = substr( $rawPostedData, 0, $i );

// Calculating Key (Notification Signature)
$calculatedKey = md5( $fieldValuePairsData . $pvs_global_settings["paxum_password"] );

// Verifying Notification Key (Signature)
$isValid = $_POST["key"] == $calculatedKey ? true : false;

if ( ! $isValid ) {
	echo "This is not a valid notification message";
	exit;
}

$mass = explode( "-", pvs_result( $_POST["transaction_item_id"] ) );
$product_type = $mass[0];
$id = ( int )$mass[1];
$transaction_id = pvs_transaction_add( "paxum", ( int )$_POST["transaction_id"], pvs_result( $product_type ), $id );

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
?>