<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["moneyua_active"] ) {
	exit();
}

if ( $_POST ) {
	$control_hash = md5( $_POST["RETURN_MERCHANT"] . ":" . $_POST["RETURN_ADDVALUE"] .
		":" . $_POST["RETURN_CLIENTORDER"] . ":" . $_POST["RETURN_AMOUNT"] . ":" . $_POST["RETURN_COMISSION"] .
		":" . $_POST["RETURN_UNIQ_ID"] . ":" . $_POST["TEST_MODE"] . ":" . $_POST["PAYMENT_DATE"] .
		":" . $pvs_global_settings["moneyua_password"] . ":" . $_POST["RETURN_RESULT"] );

	if ( $_POST["RETURN_HASH"] == $control_hash ) {
		if ( $_POST["RETURN_RESULT"] == 20 ) {
			echo ( "OK" );

			$mass = explode( "-", $_POST["RETURN_CLIENTORDER"] );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			$transaction_id = pvs_transaction_add( "moneyua", ( int )$_POST["RETURN_UNIQ_ID"],
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