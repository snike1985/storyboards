<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["cashu_active"] ) {
	if ( $pvs_global_settings["cashu_ipn"] ) {
		$token = md5( $pvs_global_settings["cashu_account"] . ":" . $_POST["amount"]  . ":" . strtolower( pvs_get_currency_code(1) ) . ":" . $pvs_global_settings["cashu_password"] );
		
		if ( $token == $_POST["token"] ) {
			$transaction_id = pvs_transaction_add( "cashu", $_POST["trn_id"], $_POST["txt1"], $_POST["txt2"] );

			if ( $_POST["txt1"] == "credits" and ! pvs_is_order_approved( $_POST["txt2"], 'credits' ) )
			{
				pvs_send_notification( 'credits_to_user', $_POST["x_invoice_num"] );
				pvs_send_notification( 'credits_to_admin', $_POST["x_invoice_num"] );
				pvs_credits_approve( $_POST["x_invoice_num"], $transaction_id );
			}

			if ( $_POST["txt1"] == "subscription" and ! pvs_is_order_approved( $_POST["txt2"], 'subscription' ) )
			{
				pvs_subscription_approve( $_POST["txt2"] );
				pvs_send_notification( 'subscription_to_user', $_POST["x_invoice_num"] );
				pvs_send_notification( 'subscription_to_admin', $_POST["x_invoice_num"] );
			}

			if ( $_POST["txt1"] == "order" and ! pvs_is_order_approved( $_POST["txt2"], 'order' ) )
			{
				pvs_order_approve( $_POST["txt2"] );
				pvs_commission_add( $_POST["txt2"] );

				pvs_coupons_add( pvs_order_user( $_POST["txt2"] ) );
				pvs_send_notification( 'neworder_to_user', $_POST["txt2"] );
				pvs_send_notification( 'neworder_to_admin', $_POST["txt2"] );
			}
		}
	}
}
?>