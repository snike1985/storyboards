<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["midtrans_active"] ) {
	exit();
}

require_once ( PVS_PATH . 'includes/plugins/veritrans/Veritrans.php' );

if ( $pvs_global_settings["midtrans_test"] ) {
	Veritrans_Config::$isProduction = false;
} else
{
	Veritrans_Config::$isProduction = true;
}

Veritrans_Config::$serverKey = $pvs_global_settings["midtrans_password"];
$notif = new Veritrans_Notification();

$transaction = $notif->transaction_status;
$type = $notif->payment_type;
$order_id = $notif->order_id;
$fraud = $notif->fraud_status;

$crc = explode( "-", $order_id );
$id = ( int )$crc[1];
$product_type = pvs_result( $crc[0] );

$flag = false;

if ( $transaction == 'capture' ) {
	// For credit card transaction, we need to check whether transaction is challenge by FDS or not
	if ( $type == 'credit_card' ) {
		if ( $fraud == 'challenge' ) {
			// TODO set payment status in merchant's database to 'Challenge by FDS'
			// TODO merchant should decide whether this transaction is authorized or not in MAP
			echo "Transaction order_id: " . $order_id . " is challenged by FDS";
		} else {
			// TODO set payment status in merchant's database to 'Success'
			echo "Transaction order_id: " . $order_id . " successfully captured using " . $type;
			$flag = true;
		}
	}

	if ( $flag ) {

		$transaction_id = pvs_transaction_add( "midtrans", "", $product_type, $id );

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
	if ( $transaction == 'settlement' ) {
		// TODO set payment status in merchant's database to 'Settlement'
		echo "Transaction order_id: " . $order_id . " successfully transfered using " .
			$type;
	} else
		if ( $transaction == 'pending' ) {
			// TODO set payment status in merchant's database to 'Pending'
			echo "Waiting customer to finish transaction order_id: " . $order_id . " using " .
				$type;
		} else
			if ( $transaction == 'deny' )
			{
				// TODO set payment status in merchant's database to 'Denied'
				echo "Payment using " . $type . " for transaction order_id: " . $order_id .
					" is denied.";
			} else
				if ( $transaction == 'expire' )
				{
					// TODO set payment status in merchant's database to 'expire'
					echo "Payment using " . $type . " for transaction order_id: " . $order_id .
						" is expired.";
				} else
					if ( $transaction == 'cancel' )
					{
						// TODO set payment status in merchant's database to 'Denied'
						echo "Payment using " . $type . " for transaction order_id: " . $order_id .
							" is canceled.";
					}
?>