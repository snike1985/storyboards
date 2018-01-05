<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["authorize_active"] ) {
	if ( $pvs_global_settings["authorize_ipn"] ) {	
		if ( $_POST['x_response_code'] == 1 ) {
			$md5 = md5( $pvs_global_settings["authorize_password"] . $pvs_global_settings["authorize_account"] . $_POST["x_trans_id"] .
				$_POST['x_amount'] );
			if ( strtoupper( $md5 ) != $_POST['x_MD5_Hash'] ) {
				exit();
			}
		
			$transaction_id = pvs_transaction_add( "authorize", $_POST["x_trans_id"],
				"credits", $_POST["x_invoice_num"] );
		
			if ( $_POST["x_description"] == "credits"  and ! pvs_is_order_approved( $_POST["x_invoice_num"], 'credits' ) ) {
				pvs_send_notification( 'credits_to_user', $_POST["x_invoice_num"] );
				pvs_send_notification( 'credits_to_admin', $_POST["x_invoice_num"] );
				pvs_credits_approve( $_POST["x_invoice_num"], $transaction_id );
			}
		
			if ( $_POST["x_description"] == "subscription" and ! pvs_is_order_approved( $_POST["x_invoice_num"], 'subscription' ) ) {
				pvs_subscription_approve( $_POST["x_invoice_num"] );
				pvs_send_notification( 'subscription_to_user', $_POST["x_invoice_num"] );
				pvs_send_notification( 'subscription_to_admin', $_POST["x_invoice_num"] );
			}
		
			if ( $_POST["x_description"] == "order" and ! pvs_is_order_approved( $_POST["x_invoice_num"], 'order' ) ) {
				pvs_order_approve( $_POST["x_invoice_num"] );
				pvs_commission_add( $_POST["x_invoice_num"] );
				pvs_coupons_add( pvs_order_user( $_POST["x_invoice_num"] ) );
				pvs_send_notification( 'neworder_to_user', $_POST["x_invoice_num"] );
				pvs_send_notification( 'neworder_to_admin', $_POST["x_invoice_num"] );
			}
		}
	}
}
?>