<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["payson_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

/*
* Payson API Integration example for PHP
*
* More information can be found att https://api.payson.se
*
*/

/*
* On every page you need to use the API you
* need to include the file lib/paysonapi.php
* from where you installed it.
*/

require_once PVS_PATH . 'includes/plugins/payson/paysonapi.php';

/*
* Account information. Below is all the variables needed to perform a purchase with
* payson. Replace the placeholders with your actual information 
*/

// Your agent ID and md5 key
$agentID = $pvs_global_settings["payson_account2"];
$md5Key = $pvs_global_settings["payson_password"];

// URLs used by payson for redirection after a completed/canceled purchase.

$returnURL = site_url( ) . "/payment-success/";
$cancelURL = site_url( ) . "/payment-fail/";

// Please note that only IP/URLS accessible from the internet will work
$ipnURL = site_url( ) . "/payment-notification/?payment=payson";

// Account details of the receiver of money
$receiverEmail = $pvs_global_settings["payson_account"];

// Amount to send to receiver
$amountToReceive = $product_total;

// Information about the sender of money
$user_info = get_userdata(get_current_user_id());
$senderEmail = @$user_info -> user_email;
$senderFirstname = @$user_info -> first_name;
$senderLastname = @$user_info -> last_name;

/* Every interaction with Payson goes through the PaysonApi object which you set up as follows.
* For the use of our test or live environment use one following parameters:
* TRUE: Use test environment, FALSE: use live environment */
$credentials = new PaysonCredentials( $agentID, $md5Key );
$api = new PaysonApi( $credentials, TRUE );

/*
* To initiate a direct payment the steps are as follows
*  1. Set up the details for the payment
*  2. Initiate payment with Payson
*  3. Verify that it suceeded
*  4. Forward the user to Payson to complete the payment
*/

/*
* Step 1: Set up details
*/

// Details about the receiver
$receiver = new Receiver( $receiverEmail,
	// The email of the account to receive the money
	$amountToReceive ); // The amount you want to charge the user, here in SEK (the default currency)
$receivers = array( $receiver );

// Details about the user that is the sender of the money
$sender = new Sender( $senderEmail, $senderFirstname, $senderLastname );

$payData = new PayData( $returnURL, $cancelURL, $ipnURL, $product_name, $sender,
	$receivers );

//Set the list of products. For direct payment this is optional
$orderItems = array();
$orderItems[] = new OrderItem( $product_type . "-" . $product_id, $product_total,
	1, 0, $product_id );

$payData->setOrderItems( $orderItems );

//Set the payment method
//$constraints = array(FundingConstraint::BANK, FundingConstraint::CREDITCARD); // bank and card
//$constraints = array(FundingConstraint::INVOICE); // only invoice
$constraints = array(
	FundingConstraint::BANK,
	FundingConstraint::CREDITCARD,
	FundingConstraint::INVOICE ); // bank, card and invoice
//$constraints = array(FundingConstraint::BANK); // only bank
$payData->setFundingConstraints( $constraints );

//Set the payer of Payson fees
//Must be PRIMARYRECEIVER if using FundingConstraint::INVOICE
$payData->setFeesPayer( FeesPayer::PRIMARYRECEIVER );

// Set currency code
$payData->setCurrencyCode( CurrencyCode::SEK );

// Set locale code
$payData->setLocaleCode( LocaleCode::SWEDISH );

// Set guarantee options
$payData->setGuaranteeOffered( GuaranteeOffered::OPTIONAL );

/*
* Step 2 initiate payment
*/
$payResponse = $api->pay( $payData );

/*
* Step 3: verify that it suceeded
*/

//var_dump($payResponse);

if ( $payResponse->getResponseEnvelope()->wasSuccessful() ) {
	/*
	* Step 4: forward user
	*/
	//header("Location: " . $api->getForwardPayUrl($payResponse));
	$url = $api->getForwardPayUrl( $payResponse );
} else
{
	$url = $cancelURL;
}
?>
    <form action="<?php echo $url
?>" method="post"  name="process" id="process">
    </form>
<?php
pvs_show_payment_page( 'footer' );
?>