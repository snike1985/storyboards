<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["paypal_active"] ) {
	if ( $pvs_global_settings["paypal_ipn"] ) {
		$postdata = "";
		foreach ( $_REQUEST as $key => $value )
			$postdata .= $key . "=" . urlencode( $value ) . "&";
		$postdata .= "cmd=_notify-validate";

		$curl = curl_init( 'https://www.paypal.com/cgi-bin/webscr' );

		curl_setopt( $curl, CURLOPT_HTTP_VERSION, CURL_HTTP_VERSION_1_1 );
		curl_setopt( $curl, CURLOPT_POST, 1 );
		curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
		curl_setopt( $curl, CURLOPT_POSTFIELDS, $postdata );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 1 );
		curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 2 );
		curl_setopt( $curl, CURLOPT_FORBID_REUSE, 1 );
		curl_setopt( $curl, CURLOPT_HTTPHEADER, array( 'Connection: Close' ) );
		$response = curl_exec( $curl );
		curl_close( $curl );

		/*
		$response = "VERIFIED";
		$_REQUEST["txn_type"] = "cart";
		$_REQUEST["payment_status"] = "Completed";
		$_REQUEST["item_number"]=18;
		*/


		//Recurring subscriptions
		if ( $response == "VERIFIED" )
		{
			if ( $_REQUEST["txn_type"] == "subscr_signup" )
			{
				$sql = "update " . PVS_DB_PREFIX . "subscription_list set subscr_id='" .
					pvs_result( $_REQUEST["subscr_id"] ) . "' where id_parent=" . ( int )$_REQUEST["item_number"];
				$db->execute( $sql );
				exit();
			}

			if ( $_REQUEST["txn_type"] == "subscr_payment" and $_REQUEST["payment_status"] ==
				"Completed" )
			{
				$sql = "select * from " . PVS_DB_PREFIX . "subscription_list where id_parent=" . ( int )
					$_REQUEST["item_number"];
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					if ( $ds->row["payments"] == 0 )
					{
						pvs_subscription_approve( $_REQUEST["item_number"] );
						pvs_send_notification( 'subscription_to_user', $_REQUEST["item_number"] );
						pvs_send_notification( 'subscription_to_admin', $_REQUEST["item_number"] );
					} else
					{
						$sql = "select days from " . PVS_DB_PREFIX . "subscription where id_parent=" . $ds->
							row["subscription"];
						$rs->open( $sql );
						if ( ! $rs->eof )
						{
							if ( pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
								date( "Y" ) ) - $ds->row["recurring_data"] > 23 * 3600 )
							{
								$sql = "update " . PVS_DB_PREFIX .
									"subscription_list set bandwidth=0,data2=data2+" . ( 3600 * 24 * $rs->row["days"] ) .
									",payments=payments+1,recurring_data=" . pvs_get_time( date( "H" ), date( "i" ),
									date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) . " where id_parent=" . ( int )
									$_REQUEST["item_number"];
								$db->execute( $sql );
							}
						}
					}
				}

				exit();
			}
		}

		//Items
		if ( $response == "VERIFIED" and $_REQUEST["payment_status"] == "Completed" and ( $_REQUEST["txn_type"] ==
			"web_accept" or $_REQUEST["txn_type"] == "cart" or $_REQUEST["txn_type"] ==
			"send_money" ) )
		{
			$transaction_id = pvs_transaction_add( "paypal", @$_REQUEST["txn_id"], $_REQUEST["product_type"],
				$_REQUEST["item_number"] );

			if ( $_REQUEST["product_type"] == "credits" and ! pvs_is_order_approved( $_REQUEST["item_number"], 'credits' ) )
			{
				pvs_credits_approve( $_REQUEST["item_number"], $transaction_id );
				pvs_send_notification( 'credits_to_user', $_REQUEST["item_number"] );
				pvs_send_notification( 'credits_to_admin', $_REQUEST["item_number"] );
			}

			if ( $_REQUEST["product_type"] == "subscription" and ! pvs_is_order_approved( $_REQUEST["item_number"], 'subscription' ) )
			{
				pvs_subscription_approve( $_REQUEST["item_number"] );
				pvs_send_notification( 'subscription_to_user', $_REQUEST["item_number"] );
				pvs_send_notification( 'subscription_to_admin', $_REQUEST["item_number"] );
			}

			if ( $_REQUEST["product_type"] == "order" and ! pvs_is_order_approved( $_REQUEST["item_number"], 'order' ) )
			{
				pvs_order_approve( $_REQUEST["item_number"] );
				pvs_commission_add( $_REQUEST["item_number"] );

				pvs_coupons_add( pvs_order_user( $_REQUEST["item_number"] ) );
				pvs_send_notification( 'neworder_to_user', $_REQUEST["item_number"] );
				pvs_send_notification( 'neworder_to_admin', $_REQUEST["item_number"] );
			}
		}
	}
}
?>