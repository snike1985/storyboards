<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payfast_active"] ) {
	exit();
}

/**
 * Notes:
 * - All lines with the suffix "// DEBUG" are for debugging purposes and
 *   can safely be removed from live code.
 * - Remember to set PAYFAST_SERVER to LIVE for production/live site
 */
// General defines
define( 'PAYFAST_SERVER', 'LIVE' );
// Whether to use "sandbox" test server or live server
define( 'USER_AGENT', 'Mozilla/4.0 (compatible; MSIE 5.01; Windows NT 5.0)' );
// User Agent for cURL

// Messages
// Error
define( 'PF_ERR_AMOUNT_MISMATCH', 'Amount mismatch' );
define( 'PF_ERR_BAD_SOURCE_IP', 'Bad source IP address' );
define( 'PF_ERR_CONNECT_FAILED', 'Failed to connect to PayFast' );
define( 'PF_ERR_BAD_ACCESS', 'Bad access of page' );
define( 'PF_ERR_INVALID_SIGNATURE', 'Security signature mismatch' );
define( 'PF_ERR_CURL_ERROR', 'An error occurred executing cURL' );
define( 'PF_ERR_INVALID_DATA', 'The data received is invalid' );
define( 'PF_ERR_UKNOWN', 'Unknown error occurred' );

// General
define( 'PF_MSG_OK', 'Payment was successful' );
define( 'PF_MSG_FAILED', 'Payment has failed' );

// Notify PayFast that information has been received
header( 'HTTP/1.0 200 OK' );
flush();

// Variable initialization
$pfError = false;
$pfErrMsg = '';
$filename = 'notify.txt'; // DEBUG
$output = ''; // DEBUG
$pfParamString = '';
$pfHost = ( PAYFAST_SERVER == 'LIVE' ) ? 'www.payfast.co.za' :
	'sandbox.payfast.co.za';

//// Dump the submitted variables and calculate security signature
if ( ! $pfError ) {
	$output = "Posted Variables:\n\n"; // DEBUG

	// Strip any slashes in data
	foreach ( $_POST as $key => $val )
		$pfData[$key] = stripslashes( $val );

	// Dump the submitted variables and calculate security signature
	foreach ( $pfData as $key => $val ) {
		if ( $key != 'signature' )
			$pfParamString .= $key . '=' . urlencode( $val ) . '&';
	}

	// Remove the last '&' from the parameter string
	$pfParamString = substr( $pfParamString, 0, -1 );
	$signature = md5( $pfParamString );

	$result = ( $_POST['signature'] == $signature );

	$output .= "Security Signature:\n\n"; // DEBUG
	$output .= "- posted     = " . $_POST['signature'] . "\n"; // DEBUG
	$output .= "- calculated = " . $signature . "\n"; // DEBUG
	$output .= "- result     = " . ( $result ? 'SUCCESS' : 'FAILURE' ) . "\n"; // DEBUG
}

//// Verify source IP
if ( ! $pfError ) {
	$validHosts = array(
		'www.payfast.co.za',
		'sandbox.payfast.co.za',
		'w1w.payfast.co.za',
		'w2w.payfast.co.za',
		);

	$validIps = array();

	foreach ( $validHosts as $pfHostname ) {
		$ips = gethostbynamel( $pfHostname );

		if ( $ips !== false )
			$validIps = array_merge( $validIps, $ips );
	}

	// Remove duplicates
	$validIps = array_unique( $validIps );

	if ( ! in_array( $_SERVER['REMOTE_ADDR'], $validIps ) ) {
		$pfError = true;
		$pfErrMsg = PF_ERR_BAD_SOURCE_IP;
	}
}

//// Connect to server to validate data received
if ( ! $pfError ) {
	// Use cURL (If it's available)
	if ( function_exists( 'curl_init' ) ) {
		$output .= "\n\nUsing cURL\n\n"; // DEBUG

		// Create default cURL object
		$ch = curl_init();

		// Base settings
		$curlOpts = array(
			// Base options
			CURLOPT_USERAGENT => USER_AGENT, // Set user agent
			CURLOPT_RETURNTRANSFER => true, // Return output as string rather than outputting it
			CURLOPT_HEADER => false, // Don't include header in output
			CURLOPT_SSL_VERIFYHOST => true,
			CURLOPT_SSL_VERIFYPEER => false,

			// Standard settings
			CURLOPT_URL => 'https://' . $pfHost . '/eng/query/validate',
			CURLOPT_POST => true,
			CURLOPT_POSTFIELDS => $pfParamString,
			);
		curl_setopt_array( $ch, $curlOpts );

		// Execute CURL
		$res = curl_exec( $ch );
		curl_close( $ch );

		if ( $res === false ) {
			$pfError = true;
			$pfErrMsg = PF_ERR_CURL_ERROR;
		}
	}
	// Use fsockopen
	else {
		$output .= "\n\nUsing fsockopen\n\n"; // DEBUG

		// Construct Header
		$header = "POST /eng/query/validate HTTP/1.0\r\n";
		$header .= "Host: " . $pfHost . "\r\n";
		$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
		$header .= "Content-Length: " . strlen( $pfParamString ) . "\r\n\r\n";

		// Connect to server
		$socket = fsockopen( 'ssl://' . $pfHost, 443, $errno, $errstr, 10 );

		// Send command to server
		fputs( $socket, $header . $pfParamString );

		// Read the response from the server
		$res = '';
		$headerDone = false;

		while ( ! feof( $socket ) ) {
			$line = fgets( $socket, 1024 );

			// Check if we are finished reading the header yet
			if ( strcmp( $line, "\r\n" ) == 0 )
			{
				// read the header
				$headerDone = true;
			}
			// If header has been processed
			else
				if ( $headerDone )
				{
					// Read the main response
					$res .= $line;
				}
		}
	}
}

//// Get data from server
if ( ! $pfError ) {
	// Parse the returned data
	$lines = explode( "\n", $res );

	$output .= "\n\nValidate response from server:\n\n"; // DEBUG

	foreach ( $lines as $line ) // DEBUG

		$output .= $line . "\n"; // DEBUG
}

//// Interpret the response from server
if ( ! $pfError ) {
	// Get the response from PayFast (VALID or INVALID)
	$result = trim( $lines[0] );

	$output .= "\nResult = " . $result; // DEBUG

	// If the transaction was valid
	if ( strcmp( $result, 'VALID' ) == 0 ) {
		$mass = explode( "-", pvs_result( $_POST["m_payment_id"] ) );
		$product_type = $mass[0];
		$id = ( int )$mass[1];
		$transaction_id = pvs_transaction_add( "payfast", ( int )$_POST["pf_payment_id"],
			pvs_result( $product_type ), $id );

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
	// If the transaction was NOT valid
	else {
		// Log for investigation
		$pfError = true;
		$pfErrMsg = PF_ERR_INVALID_DATA;
	}
}

// If an error occurred
if ( $pfError ) {
	$output .= "\n\nAn error occurred!";
	$output .= "\nError = " . $pfErrMsg;
}

//// Write output to file // DEBUG
//file_put_contents( $filename, $output ); // DEBUG
?>