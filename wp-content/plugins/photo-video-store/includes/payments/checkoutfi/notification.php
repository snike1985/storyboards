<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["checkoutfi_active"] ) {
	include ( PVS_PATH . 'includes/plugins/checkout.fi/CheckoutFinland/Response.php' );
	
	$demo_merchant_secret = $pvs_global_settings["checkoutfi_password"];
	
	$response = new Response( $demo_merchant_secret );
	
	$response->setRequestParams( $_GET );
	
	$status_string = '';
	
	if ( $response->validate() ) {
		// we have a valid response, now check the status
	
		// the status codes are listed in the api documentation of Checkout Finland
		switch ( $response->getStatus() ) {
			case '2':
			case '5':
			case '6':
			case '8':
			case '9':
			case '10':
				// These are paid and we can ship the product
				$status_string = 'PAID';
				break;
			case '7':
			case '3':
			case '4':
				// Payment delayed or it is not known yet if the payment was completed
				$status_string = 'DELAYED';
				break;
			case '-1':
				$status_string = 'CANCELLED BY USER';
				break;
			case '-2':
			case '-3':
			case '-4':
			case '-10':
				// Cancelled by banks, Checkout Finland, time out e.g.
				$status_string = 'CANCELLED';
				break;
		}
	
	} else
	{
		// something went wrong with the validation, perhaps the user changed the return parameters
	}
	
	if ( $status_string == "PAID" ) {
		$crc = explode( "-", $_REQUEST["reference"] );
		$id = ( int )$crc[1];
		$product_type = pvs_result( $crc[0] );
	
		$transaction_id = pvs_transaction_add( "checkoutfi", "", $product_type, $id );
	
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
?>