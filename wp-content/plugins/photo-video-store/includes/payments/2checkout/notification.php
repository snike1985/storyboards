<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["2checkout_active"] ) {
	if ( $pvs_global_settings["2checkout_ipn"] ) {
		if ( $_POST['credit_card_processed'] == 'Y' )
		{
/*
Fix it
			$transaction_id = pvs_transaction_add( "2checkout", $_POST["order_number"], "credits", $_POST["cart_order_id"] );

			if ( $_POST["product_type"] == "credits" and ! pvs_is_order_approved( $_POST["cart_order_id"], 'credits' )  )
			{
				pvs_credits_approve( $_POST["cart_order_id"], $transaction_id );
				pvs_send_notification( 'credits_to_user', $_POST["cart_order_id"] );
				pvs_send_notification( 'credits_to_admin', $_POST["cart_order_id"] );
			}
			if ( $_POST["product_type"] == "subscription" and ! pvs_is_order_approved( $_POST["cart_order_id"], 'subscription' ) )
			{
				pvs_subscription_approve( $_POST["cart_order_id"] );
				pvs_send_notification( 'subscription_to_user', $_POST["cart_order_id"] );
				pvs_send_notification( 'subscription_to_admin', $_POST["cart_order_id"] );
			}

			if ( $_POST["product_type"] == "order"  and ! pvs_is_order_approved( $_POST["cart_order_id"], 'order' ) )
			{
				pvs_order_approve( $_POST["cart_order_id"] );
				pvs_commission_add( $_POST["cart_order_id"] );

				pvs_coupons_add( pvs_order_user( $_POST["cart_order_id"] ) );
				pvs_send_notification( 'neworder_to_user', $_POST["cart_order_id"] );
				pvs_send_notification( 'neworder_to_admin', $_POST["cart_order_id"] );
			}
*/
		}
	}
}
?>