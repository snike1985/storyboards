<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["epoch_active"] ) {
	if ( $pvs_global_settings["epoch_ipn"] ) {
		if ( eregi( "^Y", $_GET['ans'] ) and eregi( "208.236.105.", $_SERVER['HTTP_REFERER'] ) )
		{
			if ( $_GET["product_type"] == "credits" and ! pvs_is_order_approved( $_REQUEST["pid"], 'credits' )  )
			{
				pvs_credits_approve( $_GET["pid"], $_GET['ans'] );
				pvs_send_notification( 'credits_to_user', $_GET["pid"] );
				pvs_send_notification( 'credits_to_admin', $_GET["pid"] );
			}

			if ( $_GET["product_type"] == "subscription" and ! pvs_is_order_approved( $_REQUEST["pid"], 'subscription' )  )
			{
				pvs_subscription_approve( $_GET["pid"] );
				pvs_send_notification( 'subscription_to_user', $_GET["pid"] );
				pvs_send_notification( 'subscription_to_admin', $_GET["pid"] );
			}

			header( "location:" . site_url( ) . "/payment-success/" );
			exit();
		}
	}
}
?>