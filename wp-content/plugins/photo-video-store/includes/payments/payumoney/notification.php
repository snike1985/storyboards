<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payumoney_active"] ) {
	exit();
}

$status = $_POST["status"];
$firstname = $_POST["firstname"];
$amount = $_POST["amount"];
$txnid = $_POST["txnid"];
$posted_hash = $_POST["hash"];
$key = $_POST["key"];
$productinfo = $_POST["productinfo"];
$email = $_POST["email"];
$salt = $pvs_global_settings["payumoney_password"];

If ( isset( $_POST["additionalCharges"] ) ) {
	$additionalCharges = $_POST["additionalCharges"];
	$retHashSeq = $additionalCharges . '|' . $salt . '|' . $status . '|||||||||||' .
		$email . '|' . $firstname . '|' . $productinfo . '|' . $amount . '|' . $txnid .
		'|' . $key;

} else
{

	$retHashSeq = $salt . '|' . $status . '|||||||||||' . $email . '|' . $firstname .
		'|' . $productinfo . '|' . $amount . '|' . $txnid . '|' . $key;

}
$hash = hash( "sha512", $retHashSeq );

if ( $hash != $posted_hash ) {
	echo "Invalid Transaction. Please try again";
} else
{

	$crc = explode( "-", $_POST["txnid"] );
	$id = ( int )$crc[1];
	$product_type = pvs_result( $crc[0] );

	$transaction_id = pvs_transaction_add( "payumoney", "", $product_type, $id );

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

	echo "<h3>Thank You. Your order status is " . $status .
		".</h3><meta http-equiv='refresh' content=\"3; url=" . site_url( ).
		"/profile/\">";

}
?>