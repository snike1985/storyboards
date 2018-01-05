<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["eway_active"] ) {
	if ( $pvs_global_settings["eway_ipn"] ) {
		/* Fix it
		if ( $_POST['ewayTrxnStatus'] == "True" )
		{
			echo ( "Ñongratulation! The transaction is successfull." );

			$transaction_id = pvs_transaction_add( "authorize", $_POST["ewayTrxnReference"],
				$_POST["eWAYoption1"], $_POST["eWAYoption2"] );

			if ( $_POST["eWAYoption1"] == "credits" and ! pvs_is_order_approved( $_POST["eWAYoption2"], 'credits' ) )
			{
				pvs_send_notification( 'credits_to_user', $_POST["eWAYoption2"] );
				pvs_send_notification( 'credits_to_admin', $_POST["eWAYoption2"] );
				pvs_credits_approve( $_POST["eWAYoption2"], $transaction_id );
			}

			if ( $_POST["eWAYoption1"] == "subscription" and ! pvs_is_order_approved( $_POST["eWAYoption2"], 'subscription' ))
			{
				pvs_subscription_approve( $_POST["eWAYoption2"] );
				pvs_send_notification( 'subscription_to_user', $_POST["eWAYoption2"] );
				pvs_send_notification( 'subscription_to_admin', $_POST["eWAYoption2"] );
			}

			if ( $_POST["eWAYoption1"] == "order" and ! pvs_is_order_approved( $_POST["eWAYoption2"], 'order' ) )
			{
				pvs_order_approve( $_POST["eWAYoption2"] );
				pvs_commission_add( $_POST["eWAYoption2"] );
				pvs_coupons_add( pvs_order_user( $_POST["eWAYoption2"] ) );
				pvs_send_notification( 'neworder_to_user', $_POST["eWAYoption2"] );
				pvs_send_notification( 'neworder_to_admin', $_POST["eWAYoption2"] );

			}
			header( "header:" . site_url( ) . "/payment-success/" );
		} else
		{
			header( "header:" . site_url( ) . "/payment-fail/" );
		}
		*/
	}
}
?>