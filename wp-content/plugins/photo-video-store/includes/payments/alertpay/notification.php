<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["alertpay_active"] ) {
	if ( $pvs_global_settings["alertpay_ipn"] ) {
		if ( $pvs_global_settings["alertpay_password"] == $_POST["ap_securitycode"] and $_POST["ap_status"] == "Success" )
		{

			$transaction_id = pvs_transaction_add( "alertpay", $_POST["ap_referencenumber"],
				$_POST["ap_description"], $_POST["ap_itemcode"] );

			if ( $_POST["ap_description"] == "credits" and ! pvs_is_order_approved( $_POST["ap_itemcode"], 'credits' )  )
			{
				pvs_credits_approve( $_POST["ap_itemcode"], $transaction_id );
				pvs_send_notification( 'credits_to_user', $_POST["ap_itemcode"] );
				pvs_send_notification( 'credits_to_admin', $_POST["ap_itemcode"] );
			}

			if ( $_POST["ap_description"] == "subscription" and ! pvs_is_order_approved( $_POST["ap_itemcode"], 'subscription' )  )
			{
				pvs_subscription_approve( $_POST["ap_itemcode"] );
				pvs_send_notification( 'subscription_to_user', $_POST["ap_itemcode"] );
				pvs_send_notification( 'subscription_to_admin', $_POST["ap_itemcode"] );
			}

			if ( $_POST["ap_description"] == "order" and ! pvs_is_order_approved( $_POST["ap_itemcode"], 'order' )  )
			{
				pvs_order_approve( $_POST["ap_itemcode"] );
				pvs_commission_add( $_POST["ap_itemcode"] );

				pvs_coupons_add( pvs_order_user( $_POST["ap_itemcode"] ) );
				pvs_send_notification( 'neworder_to_user', $_POST["ap_itemcode"] );
				pvs_send_notification( 'neworder_to_admin', $_POST["ap_itemcode"] );
			}
		}
	}
}
?>