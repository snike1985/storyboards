<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header', true );

if ( $pvs_global_settings["dwolla_active"] ) {
	?>
	<h1><?php echo pvs_word_lang( "payment" )?></h1>
	
	<?php
	if ( isset( $_GET["error"] ) ) {
		echo ( "<p><b>" . pvs_result( $_GET["error"] ) . "</b></p>" );
		echo ( "<p>" . pvs_result( $_GET["error_description"] ) . "</b>" );
	} elseif ( isset( $_GET["signature"] ) ) {
	
		function verifyGatewaySignature( $proposedSignature, $checkoutId, $amount ) {
			global $pvs_global_settings;
			$amount = number_format( $amount, 2 );
			$signature = hash_hmac( "sha1", "{$checkoutId}&{$amount}", $pvs_global_settings["dwolla_password"] );
			return $signature == $proposedSignature;
		}
	
		$didVerify = verifyGatewaySignature( $_GET["signature"], $_GET["checkoutId"], $_GET["amount"] );
	
		if ( $didVerify and $_GET["postback"] == "success" ) {
	
			$prod = explode( "-", pvs_result( $_GET["orderId"] ) );
			$id = ( int )$prod[1];
			$desc = $prod[0];
	
			$transaction_id = pvs_transaction_add( "dwolla", pvs_result( $_GET["transaction"] ),
				$desc, $id );
	
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
	
			echo ( "Thank you! Your transaction has been sent successfully." );
		} else {
			echo ( "Error. The transaction has been declined!" );
		}
	} else
	{
		echo ( "<p><b>Error!</b> No data.</p>" );
	}
}

pvs_show_payment_page( 'footer', true );
?>