<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payprin_active"] ) {
	exit();
}

$pin = $pvs_global_settings["payprin_password"];

if ( ! $_REQUEST['UMresponseHash'] ) {
	die( 'Gateway did not return a response hash' );
}

$tmp = explode( '/', $_REQUEST['UMresponseHash'] );
$gatewaymethod = $tmp[0];
$gatewayseed = $tmp[1];
$gatewayhash = $tmp[2];

$prehash = $pin . ':' . $_REQUEST["UMresult"] . ':' . $_REQUEST["UMrefNum"] . ':' . $gatewayseed;

if ( $gatewaymethod == 'm' ) {
	$myhash = md5( $prehash );
} elseif ( $gatewaymethod == 's' ) {
	$myhash = sha1( $prehash );
} else
{
	die( 'Unknown hash method' );
}

if ( $myhash == $gatewayhash ) {
	echo "Transaction response validated";
	if ( $_REQUEST["UMresult"] == "A" ) {
		$product_type = pvs_result( $_REQUEST["UMdescription"] );
		$transaction_id = pvs_result( $_REQUEST["UMrefNum"] );
		$id = ( int )$_REQUEST["UMinvoice"];

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
} else
{
	echo "Invalid transaction response";
}
?>