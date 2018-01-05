<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["google_active"] ) {
	if ( $pvs_global_settings["google_ipn"] ) {
		$merchant_id = $pvs_global_settings["google_account"]; // Your Merchant ID
		$merchant_key = $pvs_global_settings["google_key"]; // Your Merchant Key
		$server_type = "checkout";
		$currency = pvs_get_currency_code(1);
		
		require_once ( PVS_PATH . 'includes/plugins/google_checkout/googleresponse.php' );
		require_once ( PVS_PATH . 'includes/plugins/google_checkout/googlemerchantcalculations.php' );
		require_once ( PVS_PATH . 'includes/plugins/google_checkout/googleresult.php' );
		require_once ( PVS_PATH . 'includes/plugins/google_checkout/googlerequest.php' );

		$Gresponse = new GoogleResponse( $merchant_id, $merchant_key );

		$Grequest = new GoogleRequest( $merchant_id, $merchant_key, $server_type, $currency );

		// Retrieve the XML sent in the HTTP POST request to the ResponseHandler
		$xml_response = isset( $HTTP_RAW_POST_DATA ) ? $HTTP_RAW_POST_DATA :
			file_get_contents( "php://input" );
		if ( get_magic_quotes_gpc() )
		{
			$xml_response = stripslashes( $xml_response );
		}
		list( $root, $data ) = $Gresponse->GetParsedXML( $xml_response );

		$kauth = base64_encode( $merchant_id . ":" . $merchant_key );

		header( "Authorization: Basic $kauth" );
		header( "Accept: application/xml" );

		switch ( $root )
		{
			case "new-order-notification":
				{

					if ( eregi( "credits", $data[$root]['shopping-cart']['items']['item']['item-name']['VALUE'] ) )
					{
						$tp = "credits";
					}

					if ( eregi( "subscription", $data[$root]['shopping-cart']['items']['item']['item-name']['VALUE'] ) )
					{
						$tp = "subscription";
					}

					if ( eregi( "order", $data[$root]['shopping-cart']['items']['item']['item-name']['VALUE'] ) )
					{
						$tp = "order";
					}

					$transaction_id = pvs_transaction_add( "google checkout", $data[$root]['google-order-number']['VALUE'],
						$tp, $data[$root]['shopping-cart']['items']['item']['item-description']['VALUE'] );

					break;
				}
			case "order-state-change-notification":
				{

					$new_financial_state = $data[$root]['new-financial-order-state']['VALUE'];

					if ( $new_financial_state == "CHARGED" )
					{

						$sql = "select ptype,pid from " . PVS_DB_PREFIX . "payments where tnumber='" . $data[$root]['google-order-number']['VALUE'] .
							"'";
						$ds->open( $sql );
						if ( ! $ds->eof )
						{

							if ( $ds->row["ptype"] == "credits" and ! pvs_is_order_approved( $ds->row["pid"], 'credits' )  )
							{
								pvs_credits_approve( $ds->row["pid"], 0 );
								pvs_send_notification( 'credits_to_user', $ds->row["pid"] );
								pvs_send_notification( 'credits_to_admin', $ds->row["pid"] );
							}

							if ( $ds->row["ptype"] == "subscription" and ! pvs_is_order_approved( $ds->row["pid"], 'subscription' )  )
							{
								pvs_subscription_approve( $ds->row["pid"] );
								pvs_send_notification( 'subscription_to_user', $ds->row["pid"] );
								pvs_send_notification( 'subscription_to_admin', $ds->row["pid"] );
							}

							if ( $ds->row["ptype"] == "order" and ! pvs_is_order_approved( $ds->row["pid"], 'order' )  )
							{
								pvs_order_approve( $ds->row["pid"] );
								pvs_commission_add( $ds->row["pid"] );
								pvs_coupons_add( pvs_order_user( $ds->row["pid"] ) );
								pvs_send_notification( 'neworder_to_user', $ds->row["pid"] );
								pvs_send_notification( 'neworder_to_admin', $ds->row["pid"] );
							}

						}

					}

					break;
				}
			default:
				break;
		}

		function get_arr_pvs_result( $child_node )
		{
			$result = array();
			if ( isset( $child_node ) )
			{
				if ( is_associative_array( $child_node ) )
				{
					$result[] = $child_node;
				} else
				{
					foreach ( $child_node as $curr_node )
					{
						$result[] = $curr_node;
					}
				}
			}
			return $result;
		}

		function is_associative_array( $var )
		{
			return is_array( $var ) && ! is_numeric( implode( '', array_keys( $var ) ) );
		}

	}
}
?>