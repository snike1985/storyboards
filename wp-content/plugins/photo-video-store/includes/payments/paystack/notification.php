<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paystack_active"] ) {
	exit();
}

pvs_show_payment_page( 'header', true );
?>
<h1><?php echo pvs_word_lang( "payment" )?></h1>





<?php
if ( isset( $_GET["trxref"] ) ) {
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, "https://api.paystack.co/transaction/verify/" . $_GET["trxref"] );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, "GET" );

	$headers = array();
	$headers[] = "Authorization: Bearer " . $pvs_global_settings["paystack_password"];

	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

	$results = curl_exec( $ch );

	if ( ! curl_errno( $ch ) ) {
		$res = json_decode( $results );

		if ( $res->status == true and $res->data->status == "success" ) {
?>
			<p>Thank you! Your transaction has been sent successfully.</p>
			<?php
			$crc = explode( "-", $_GET["trxref"] );
			$id = ( int )$crc[1];
			$product_type = pvs_result( $crc[0] );

			$transaction_id = pvs_transaction_add( "paystack", pvs_result( $res->data->
				authorization->authorization_code ), $product_type, $id );

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
	curl_close( $ch );
}

pvs_show_payment_page( 'footer', true );
?>