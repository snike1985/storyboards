<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["coinpayments_active"] ) {
	// Fill these in with the information from your CoinPayments.net account. 
	$cp_merchant_id = $pvs_global_settings["coinpayments_account"]; 
	$cp_ipn_secret = $pvs_global_settings["coinpayments_password"]; 
	$cp_debug_email = ''; 
	
	$mass = explode( "-", $_POST["item_number"] );
	$id = ( int )$mass[1];
	$product_type = pvs_result( $mass[0] );
	
	 
	function errorAndDie($error_msg) { 
		global $cp_debug_email; 
		if (!empty($cp_debug_email)) { 
			$report = 'Error: '.$error_msg."\n\n"; 
			$report .= "POST Data\n\n"; 
			foreach ($_POST as $k => $v) { 
				$report .= "|$k| = |$v|\n"; 
			} 
			mail($cp_debug_email, 'CoinPayments IPN Error', $report); 
		} 
		die('IPN Error: '.$error_msg); 
	} 
	 
	if (!isset($_POST['ipn_mode']) || $_POST['ipn_mode'] != 'hmac') { 
		errorAndDie('IPN Mode is not HMAC'); 
	} 
	 
	if (!isset($_SERVER['HTTP_HMAC']) || empty($_SERVER['HTTP_HMAC'])) { 
		errorAndDie('No HMAC signature sent.'); 
	} 
	 
	$request = file_get_contents('php://input'); 
	if ($request === FALSE || empty($request)) { 
		errorAndDie('Error reading POST data'); 
	} 
	 
	if (!isset($_POST['merchant']) || $_POST['merchant'] != trim($cp_merchant_id)) { 
		errorAndDie('No or incorrect Merchant ID passed'); 
	} 
		 
	$hmac = hash_hmac("sha512", $request, trim($cp_ipn_secret)); 
	if ($hmac != $_SERVER['HTTP_HMAC']) { 
		errorAndDie('HMAC signature does not match'); 
	} 
	 
	// HMAC Signature verified at this point, load some variables. 
	
	$txn_id = @$_POST['txn_id']; 
	$item_name = @$_POST['item_name']; 
	$item_number = @$_POST['item_number']; 
	$amount1 = floatval(@$_POST['amount1']); 
	$amount2 = floatval(@$_POST['amount2']); 
	$currency1 = @$_POST['currency1']; 
	$currency2 = @$_POST['currency2']; 
	$status = intval(@$_POST['status']); 
	$status_text = @$_POST['status_text']; 
	
	//depending on the API of your system, you may want to check and see if the transaction ID $txn_id has already been handled before at this point 
	
	
	
	if ($status >= 100 || $status == 2) { 
		// payment is complete or queued for nightly payout, success 
		$transaction_id = pvs_transaction_add( "coinpayments", $txn_id, $product_type, $id );
	
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
	
	} else if ($status < 0) { 
		//payment error, this is usually final but payments will sometimes be reopened if there was no exchange rate conversion or with seller consent 
	} else { 
		//payment is pending, you can optionally add a note to the order page 
	} 
	die('IPN OK'); 
}
?>