<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["myvirtualmerchant_active"] ) {
	exit();
}

if ( ! $pvs_global_settings["myvirtualmerchant_ipn"] ) {
	exit();
}

if ( @$_REQUEST['action'] == 'process' ) {
	pvs_show_payment_page( 'header');

	if ( isset( $_SERVER["HTTPS"] ) and $_SERVER["HTTPS"] == "on" ) {
		$url = "https://www.myvirtualmerchant.com/VirtualMerchant/process.do";
	} else {
		$url = "https://demo.myvirtualmerchant.com/VirtualMerchantDemo/process.do";
	}
	
	$fields = array(
		'ssl_merchant_id' => $pvs_global_settings["myvirtualmerchant_account"],
		'ssl_user_id' => $pvs_global_settings["myvirtualmerchant_account2"],
		'ssl_pin' => $pvs_global_settings["myvirtualmerchant_password"],
		'ssl_show_form' => 'false',
		'ssl_result_format' => 'html',
		'ssl_test_mode' => 'false',
		'ssl_receipt_link_method' => 'REDG',
		'ssl_receipt_apprvl_method' => 'POST',
		'ssl_error_url' => site_url( ) . "/payment-fail/",
		'ssl_receipt_apprvl_get_url' => site_url( ) .
			"/payment-notification/?payment=myvirtualmerchant",
		'ssl_transaction_type' => 'ccsale',
		'ssl_amount' => urlencode( pvs_result( $_POST["product_total"] ) ),
		'ssl_card_number' => urlencode( pvs_result( $_POST["card_number"] ) ),
		'ssl_exp_date' => urlencode( pvs_result( $_POST["card_month"] ) . substr( pvs_result
			( $_POST["card_year"] ), 2, 3 ) ),
		'ssl_cvv2cvc2' => urlencode( pvs_result( $_POST["cvv"] ) ),
		'ssl_invoice_number' => urlencode( pvs_result( $_POST["product_id"] ) . "-" .
			pvs_result( $_POST["product_type"] ) ) );
	
	$fields_string = '';
	foreach ( $fields as $key => $value ) {
		$fields_string .= $key . '=' . $value . '&';
	}
	rtrim( $fields_string, "&" );
	
	$ch = curl_init();
	curl_setopt( $ch, CURLOPT_URL, $url );
	curl_setopt( $ch, CURLOPT_POST, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $fields_string );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, false );
	curl_setopt( $ch, CURLOPT_SSL_VERIFYHOST, false );
	$result_text = curl_exec( $ch );
	curl_close( $ch );
	
	pvs_show_payment_page( 'footer');
} else {
	pvs_show_payment_page( 'header', true);

	/* Fix it
	if ( $_POST["result"] == 0 and $_POST["ssl_result_message"] == "APPROVAL" ) {
		$product_mass = explode( "-", $_POST["ssl_invoice_number"] );
	
		$id = ( int )$product_mass[0];
		$product_type = $product_mass[1];
		
		$transaction_id = pvs_transaction_add( "myvirtualmerchant", pvs_result( $_POST["ssl_txn_id"] ), $product_type, $d );
	
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
	*/
	?>
	<h1><?php echo pvs_word_lang( "payment" )?> - MyVirtualMerchant</h1>
	
	<p>Thank you! Your transaction has been sent successfully.</p>
	<?php
	pvs_show_payment_page( 'footer', true);
}



?>