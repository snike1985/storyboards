<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paygate_active"] ) {
	exit();
}

if ( isset( $_POST["PAYGATE_ID"] ) ) {
	$security_code = md5( $_POST["PAYGATE_ID"] . $_POST["PAY_REQUEST_ID"] . $_POST["REFERENCE"] .
		$_POST["TRANSACTION_STATUS"] . $_POST["RESULT_CODE"] . $_POST["AUTH_CODE"] . $_POST["CURRENCY"] .
		$_POST["AMOUNT"] . $_POST["RESULT_DESC"] . $_POST["TRANSACTION_ID"] . $_POST["RISK_INDICATOR"] .
		$_POST["PAY_METHOD"] . $_POST["PAY_METHOD_DETAIL"] . $_POST["USER1"] . $_POST["USER2"] .
		$_POST["USER3"] . $_POST["VAULT_ID"] . $_POST["CARD_USED"] . $_POST["EXPIRY_DATE"] .
		$pvs_global_settings["paygate_password"] );

	if ( $_POST["TRANSACTION_STATUS"] == 1 and $security_code == $_POST["CHECKSUM"] ) {
		$crc = explode( "-", $_POST["REFERENCE"] );
		$id = ( int )$crc[1];
		$product_type = pvs_result( $crc[0] );

		$transaction_id = pvs_transaction_add( "paygate", pvs_result( $_POST["TRANSACTION_ID"] ),
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
	echo ( "OK" );
}
?>