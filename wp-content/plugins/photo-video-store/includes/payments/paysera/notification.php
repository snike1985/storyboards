<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paysera_active"] ) {
	exit();
}

require_once ( PVS_PATH . 'includes/plugins/paysera/WebToPay.php' );

try
{
	$response = WebToPay::checkResponse( $_GET, array(
		'projectid' => $pvs_global_settings["paysera_account"],
		'sign_password' => $pvs_global_settings["paysera_password"],
		) );

	if ( $response['test'] !== '0' ) {
		throw new Exception( 'Testing, real payment was not made' );
	}
	if ( $response['type'] !== 'macro' ) {
		throw new Exception( 'Only macro payment callbacks are accepted' );
	}

	echo ( "OK" );

	$mass = explode( "-", $response['orderid'] );
	$product_type = $mass[0];
	$id = ( int )$mass[1];
	$transaction_id = pvs_transaction_add( "paysera", "", pvs_result( $product_type ),
		$id );

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
catch ( Exception $e ) {
	echo get_class( $e ) . ': ' . $e->getMessage();
}
?>