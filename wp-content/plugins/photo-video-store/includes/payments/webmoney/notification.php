<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["webmoney_active"] ) {
	exit();
}

$token = $_POST["LMI_PAYEE_PURSE"] . $_POST["LMI_PAYMENT_AMOUNT"] . $_POST["LMI_PAYMENT_NO"] .
	$_POST["LMI_MODE"] . $_POST["LMI_SYS_INVS_NO"] . $_POST["LMI_SYS_TRANS_NO"] . $_POST["LMI_SYS_TRANS_DATE"] .
	$pvs_global_settings["webmoney_password"] . $_POST["LMI_PAYER_PURSE"] . $_POST["LMI_PAYER_WM"];

//$token=md5($token);
$token = strtoupper( hash( 'sha256', $token ) );

if ( ( $pvs_global_settings["webmoney_password"] == $_POST["LMI_SECRET_KEY"] or
	$_POST["LMI_HASH"] == $token ) and $_POST["LMI_PAYEE_PURSE"] == $pvs_global_settings["webmoney_account"] and
	$_POST["LMI_MODE"] == 0 ) {
	$transaction_id = pvs_transaction_add( "webmoney", $_POST["LMI_SYS_TRANS_NO"], $_POST["ptype"], $_POST["LMI_PAYMENT_NO"] );
	
	$id = (int)$_POST["LMI_PAYMENT_NO"];
	$product_type = $_POST["ptype"];

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