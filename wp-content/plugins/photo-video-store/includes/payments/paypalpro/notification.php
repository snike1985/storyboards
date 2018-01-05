<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paypalpro_active"] ) {
	exit();
}

if ( ! isset( $_POST["product_id"] ) or ! isset( $_POST["product_name"] ) or !
	isset( $_POST["product_total"] ) or ! isset( $_POST["product_type"] ) ) {
	exit();
}

pvs_show_payment_page( 'header', true );
?>

<h1><?php echo pvs_word_lang( "payment" )?> - Paypal Pro</h1>

<?php
$product_id = ( int )$_POST["product_id"];
$product_name = pvs_result( $_POST["product_name"] );
$product_total = $_POST["product_total"];
$product_type = pvs_result( $_POST["product_type"] );

$buyer_info = array();
pvs_get_buyer_info( get_current_user_id(), $product_id, $product_type );

$order_info = array();
pvs_get_order_info( $product_id, $product_type );

//Check if Total is correct
if ( ! pvs_check_order_total( $product_total, $product_type, $product_id ) ) {
	//exit();
}

// Sandbox (Test) Mode Trigger
$sandbox = true;
if ( isset( $_SERVER["HTTPS"] ) and $_SERVER["HTTPS"] == "on" ) {
	$sandbox = false;
}

// PayPal API Credentials
$api_username = $sandbox ? 'sales_1312489240_biz_api1.cmsaccount.com' : $pvs_global_settings["paypalpro_account"];
$api_password = $sandbox ? '1312489287' : $pvs_global_settings["paypalpro_password"];
$api_signature = $sandbox ?
	'Ai1PaghZh5FmBLCDCTQpwG8jB264AdEdsXj.KitFPISMbvOxfQFeUdj.' : $pvs_global_settings["paypalpro_signature"];

require_once ( PVS_PATH . 'includes/plugins/paypal/paypal.nvp.class.php' );

// Setup PayPal object
$PayPalConfig = array(
	'Sandbox' => $sandbox,
	'APIUsername' => $api_username,
	'APIPassword' => $api_password,
	'APISignature' => $api_signature );
$PayPal = new PayPal( $PayPalConfig );

// Populate data arrays with order data.
$DPFields = array(
	'paymentaction' => 'Sale', // How you want to obtain payment.  Authorization indidicates the payment is a basic auth subject to settlement with Auth & Capture.  Sale indicates that this is a final sale for which you are requesting payment.  Default is Sale.
	'ipaddress' => $_SERVER['REMOTE_ADDR'], // Required.  IP address of the payer's browser.
	'returnfmfdetails' => '1'
		// Flag to determine whether you want the results returned by FMF.  1 or 0.  Default is 0.
		);

$CCDetails = array(
	'creditcardtype' => pvs_result( $_POST["card_type"] ), // Required. Type of credit card.  Visa, MasterCard, Discover, Amex, Maestro, Solo.  If Maestro or Solo, the currency code must be GBP.  In addition, either start date or issue number must be specified.
	'acct' => pvs_result( $_POST["card_number"] ), // Required.  Credit card number.  No spaces or punctuation.
	'expdate' => pvs_result( $_POST["card_month"] ) . pvs_result( $_POST["card_year"] ), // Required.  Credit card expiration date.  Format is MMYYYY
	'cvv2' => pvs_result( $_POST["cvv"] ), // Requirements determined by your PayPal account settings.  Security digits for credit card.
	'startdate' => '', // Month and year that Maestro or Solo card was issued.  MMYYYY
	'issuenumber' => '' // Issue number of Maestro or Solo card.  Two numeric digits max.
		);

$PayerInfo = array(
	'email' => $buyer_info["email"], // Email address of payer.
	'payerid' => '', // Unique PayPal customer ID for payer.
	'payerstatus' => '', // Status of payer.  Values are verified or unverified
	'business' => $buyer_info["company"] // Payer's business name.
		);

$PayerName = array(
	'salutation' => '', // Payer's salutation.  20 char max.
	'firstname' => $buyer_info["name"], // Payer's first name.  25 char max.
	'middlename' => '', // Payer's middle name.  25 char max.
	'lastname' => $buyer_info["lastname"], // Payer's last name.  25 char max.
	'suffix' => '' // Payer's suffix.  12 char max.
		);

$BillingAddress = array(
	'street' => $buyer_info["billing_address"], // Required.  First street address.
	'street2' => '', // Second street address.
	'city' => $buyer_info["billing_city"], // Required.  Name of City.
	'state' => '', // Required. Name of State or Province.
	'countrycode' => $mcountry_code[$buyer_info["billing_country"]], // Required.  Country code.
	'zip' => $buyer_info["billing_zipcode"], // Required.  Postal code of payer.
	'phonenum' => $buyer_info["telephone"] // Phone Number of payer.  20 char max.
		);

$ShippingAddress = array(
	'shiptoname' => $buyer_info["shipping_name"] . " " . $buyer_info["shipping_lastname"], // Required if shipping is included.  Person's name associated with this address.  32 char max.
	'shiptostreet' => $buyer_info["shipping_address"], // Required if shipping is included.  First street address.  100 char max.
	'shiptostreet2' => '', // Second street address.  100 char max.
	'shiptocity' => $buyer_info["shipping_city"], // Required if shipping is included.  Name of city.  40 char max.
	'shiptostate' => '', // Required if shipping is included.  Name of state or province.  40 char max.
	'shiptozip' => $buyer_info["shipping_zipcode"], // Required if shipping is included.  Postal code of shipping address.  20 char max.
	'shiptocountrycode' => $mcountry_code[$buyer_info["shipping_country"]], // Required if shipping is included.  Country code of shipping address.  2 char max.
	'shiptophonenum' => $buyer_info["telephone"]
		// Phone number for shipping address.  20 char max.
		);

$PaymentDetails = array(
	'amt' => $order_info["product_total"], // Required.  Total amount of order, including shipping, handling, and tax.
	'currencycode' => pvs_get_currency_code(1), // Required.  Three-letter currency code.  Default is USD.
	'itemamt' => $order_info["product_subtotal"], // Required if you include itemized cart details. (L_AMTn, etc.)  Subtotal of items not including S&H, or tax.
	'shippingamt' => $order_info["product_shipping"], // Total shipping costs for the order.  If you specify shippingamt, you must also specify itemamt.
	'handlingamt' => '', // Total handling costs for the order.  If you specify handlingamt, you must also specify itemamt.
	'taxamt' => $order_info["product_tax"], // Required if you specify itemized cart tax details. Sum of tax for all items on the order.  Total sales tax.
	'desc' => '', // Description of the order the customer is purchasing.  127 char max.
	'custom' => '', // Free-form field for your own use.  256 char max.
	'invnum' => $product_id, // Your own invoice or tracking number
	'BUTTONSOURCE' => 'CMSaccount_SP',
	'notifyurl' => site_url( ) .
		"/payment-notification/?payment=paypalpro&product_type=" . $product_type
		);

// Wrap all data arrays into a single, "master" array which will be passed into the class function.
$PayPalRequestData = array(
	'DPFields' => $DPFields,
	'CCDetails' => $CCDetails,
	'PayerName' => $PayerName,
	'PayerInfo' => $PayerInfo,
	'BillingAddress' => $BillingAddress,
	'PaymentDetails' => $PaymentDetails );

// Pass the master array into the PayPal class function
$PayPalResult = $PayPal->DoDirectPayment( $PayPalRequestData );

// Display results
//echo '<pre />';
//print_r($PayPalResult);

if ( @$PayPalResult["ACK"] == "Success" ) {
	$transaction_id = pvs_transaction_add( "paypal", $PayPalResult["TRANSACTIONID"],
		$_POST["product_type"], $_POST["product_id"] );
		
	$id = $_POST["product_id"];
	$product_type = $_POST["product_type"];

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
	echo ( "<p>Thank you! Your transaction has been sent successfully.</p>" );

} else
{
	echo ( @$PayPalResult["ERRORS"][0]["L_SEVERITYCODE"] . " " . @$PayPalResult["ERRORS"][0]["L_ERRORCODE"] .
		"<br>" . @$PayPalResult["ERRORS"][0]["L_SHORTMESSAGE"] . "<br>" . @$PayPalResult["ERRORS"][0]["L_LONGMESSAGE"] .
		"<br>" );
}
?>
<br><br>

<?php
if ( isset( $_POST["product_id"] ) and isset( $_POST["product_type"] ) ) {
	$_GET["product_id"] = $_POST["product_id"];
	$_GET["product_type"] = $_POST["product_type"];
	$_GET["print"] = 1;
	include ( PVS_PATH . "templates/payment_statement.php" );
}

pvs_show_payment_page( 'footer', true );
?>