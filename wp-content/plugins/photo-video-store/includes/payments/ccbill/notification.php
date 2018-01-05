<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header', true );

if ( $pvs_global_settings["ccbill_active"] ) {
	?>
	<h1><?php echo pvs_word_lang( "payment" )?></h1>
	
	<p>Thank you! Your transaction has been sent successfully.</p>
	
	<?php
	$responseDigest = md5( $_REQUEST["subscription_id"] . "1" . $pvs_global_settings["ccbill_password"] );
	
	if ( $responseDigest == $_REQUEST["responseDigest"] ) {
		$id = ( int )$_REQUEST["product_id"];
		$product_type = pvs_result( $_REQUEST["product_type"] );
	
		$transaction_id = pvs_transaction_add( "ccbill", pvs_result( $_REQUEST["subscription_id"] ), $product_type, $id );
	
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

pvs_show_payment_page( 'footer', true );
?>