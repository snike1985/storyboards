<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["privatbank_active"] ) {
	exit();
}

if ( $_POST ) {
	$signature = base64_encode( sha1( $pvs_global_settings["privatbank_password"] . $_POST["data"] . $pvs_global_settings["privatbank_password"],
		1 ) );

	$results = json_decode( base64_decode( $_POST["data"] ) );

	if ( $_POST["signature"] == $signature ) {
		if ( $results->status == "success" or $results->status == "sandbox" ) {
			$mass = explode( "-", $results->order_id );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			$transaction_id = pvs_transaction_add( "privatbank", $results->payment_id,
				pvs_result( $product_type ), $id );

			if ( $product_type == "credits" )
			{
				pvs_credits_approve( $id, $transaction_id );
				pvs_send_notification( 'credits_to_user', $id );
				pvs_send_notification( 'credits_to_admin', $id );
			}

			if ( $product_type == "subscription" )
			{
				pvs_subscription_approve( $id );
				pvs_send_notification( 'subscription_to_user', $id );
				pvs_send_notification( 'subscription_to_admin', $id );
			}

			if ( $product_type == "order" )
			{
				pvs_order_approve( $id );
				pvs_commission_add( $id );

				pvs_coupons_add( pvs_order_user( $id ) );
				pvs_send_notification( 'neworder_to_user', $id );
				pvs_send_notification( 'neworder_to_admin', $id );
			}
		}
	}
}
?>