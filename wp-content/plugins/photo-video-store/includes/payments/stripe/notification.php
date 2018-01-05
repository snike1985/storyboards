<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["stripe_active"] ) {
	exit();
}

if ( ! isset( $_REQUEST["product_id"] ) or ! isset( $_REQUEST["product_name"] ) or
	! isset( $_REQUEST["product_total"] ) or ! isset( $_REQUEST["product_type"] ) ) {
	exit();
}

pvs_show_payment_page( 'header', true );
?>

<h1><?php echo pvs_word_lang( "payment" )?> - Stripe</h1>

<?php
$user_info = get_userdata(get_current_user_id());

$product_id = ( int )$_REQUEST["product_id"];
$product_name = pvs_result( $_REQUEST["product_name"] );
$product_total = $_REQUEST["product_total"];
$product_type = pvs_result( $_REQUEST["product_type"] );

$buyer_info = array();
pvs_get_buyer_info( get_current_user_id(), $product_id, $product_type );

$order_info = array();
pvs_get_order_info( $product_id, $product_type );

//Check if Total is correct
if ( ! pvs_check_order_total( $product_total, $product_type, $product_id ) ) {
	//exit();
}

require_once ( PVS_PATH . 'includes/plugins/stripe/init.php' );
\Stripe\Stripe::setApiKey( $pvs_global_settings["stripe_password"] );

// Get the credit card details submitted by the form
$token = $_REQUEST['stripeToken'];

//Subscription
$recurring = 0;
$recurring_days = 0;

if ( $_REQUEST["product_type"] == "subscription" ) {
	$sql = "select subscription from " . PVS_DB_PREFIX .
		"subscription_list where id_parent=" . ( int )$_REQUEST["product_id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$sql = "select days,recurring from " . PVS_DB_PREFIX .
			"subscription where id_parent=" . $rs->row["subscription"];
		$ds->open( $sql );
		if ( ! $ds->eof ) {
			$recurring = $ds->row["recurring"];
			$recurring_days = $ds->row["days"];
		}
	}
}

// Create the charge on Stripe's servers - this will charge the user's card
if ( $recurring == 1 ) {
	$params = array(
		"id" => $_REQUEST["product_id"],
		"amount" => $_REQUEST["product_total"] * 100, // amount in cents, again
		"currency" => pvs_get_currency_code(1),
		"name" => pvs_result( $_REQUEST["product_name"] ),
		"interval" => "day",
		"interval_count" => $recurring_days );

	$response_plan = \Stripe\Plan::create( $params );

	$customer = \Stripe\Customer::create( array( "email" => @$user_info -> user_email,
			"source" => $token ) );

	$response_subscription = \Stripe\Subscription::create( array( "customer" => $customer->
			id, "plan" => $_REQUEST["product_id"] ) );

	$transaction_id = pvs_transaction_add( "stripe", $response_subscription->id, $_REQUEST["product_type"],
		$_REQUEST["product_id"] );

	pvs_subscription_approve( $_REQUEST["product_id"] );
	pvs_send_notification( 'subscription_to_user', $_REQUEST["product_id"] );
	pvs_send_notification( 'subscription_to_admin', $_REQUEST["product_id"] );

	echo ( "<p>Thank you! Your transaction has been sent successfully.</p>" );
} else
{
	$params = array(
		"amount" => $_REQUEST["product_total"] * 100, // amount in cents, again
		"currency" => pvs_get_currency_code(1),
		"card" => $token,
		"description" => pvs_result( $_REQUEST["product_name"] ) );

	$response = \Stripe\Charge::create( $params, array( 'idempotency_key' =>
			pvs_create_password(), ) );

	if ($response->status == 'succeeded' and $response->paid == 1) {
		$transaction_id = pvs_transaction_add( "stripe", $response->id, $_REQUEST["product_type"],
			$_REQUEST["product_id"] );
			
		$id = (int)$_REQUEST["product_id"];
		$product_type = $_REQUEST["product_type"];
	
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
	}
}
?>







<?php
pvs_show_payment_page( 'footer', true );
?>