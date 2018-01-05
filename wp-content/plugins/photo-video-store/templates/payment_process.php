<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}


$payment_type = preg_replace( '/[^a-z0-9]/i', "", @$_REQUEST["payment"] );

if ( ! isset ($pvs_payments[$payment_type]) )
{
	exit();
}




$sent = false;
$product_id = 0;
$product_name = "Test";
$product_type = "order";
$product_total = "0.00";

//Payment forms
if ( @$_REQUEST["tip"] == "credits" ) {
	$sql = "select * from " . PVS_DB_PREFIX . "credits where id_parent=" . ( int )$_REQUEST["credits"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$taxes_info = array();
		$product_id = pvs_credits_add( $rs->row["id_parent"] );
		$product_name = $rs->row["title"];
		$sql = "select total from " . PVS_DB_PREFIX . "credits_list where id_parent=" .
			$product_id;
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$product_total = $ds->row["total"];
		}
		$product_type = "credits";
		$sent = true;

	}
}

if ( @$_REQUEST["tip"] == "order" and isset( $_REQUEST["order_id"] ) ) {
	$sql = "select * from " . PVS_DB_PREFIX . "orders where id=" . ( int )$_REQUEST["order_id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$product_id = $rs->row["id"];
		$product_name = "Order #" . $rs->row["id"];
		$product_total = $rs->row["total"];
		$product_type = "order";
		$sent = true;
	}
}

if ( @$_REQUEST["tip"] == "subscription" ) {
	$sql = "select * from " . PVS_DB_PREFIX . "subscription where id_parent=" . ( int )
		$_REQUEST["subscription"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$taxes_info = array();
		$product_id = pvs_subscription_add( $rs->row["id_parent"] );
		$product_name = $rs->row["title"] . " - " . pvs_user_id_to_login( get_current_user_id());
		$sql = "select total from " . PVS_DB_PREFIX .
			"subscription_list where id_parent=" . $product_id;
		$ds->open( $sql );
		if ( ! $ds->eof )
		{
			$product_total = $ds->row["total"];
		}
		$product_type = "subscription";
		$recurring = $rs->row["recurring"];
		$recurring_days = $rs->row["days"];
		$sent = true;
	}
}

if ( $product_total == 0 ) {
	if ( $product_type == "credits" and ! pvs_is_order_approved( $product_id, 'credits' ) ) {
		pvs_credits_approve( $product_id, "" );
		pvs_send_notification( 'credits_to_user', $product_id );
		pvs_send_notification( 'credits_to_admin', $product_id );
	}

	if ( $product_type == "subscription" and ! pvs_is_order_approved( $product_id, 'subscription' ) ) {
		pvs_subscription_approve( $product_id );
		pvs_send_notification( 'subscription_to_user', $product_id );
		pvs_send_notification( 'subscription_to_admin', $product_id );
	}

	if ( $product_type == "order" and ! pvs_is_order_approved( $product_id, 'order' ) ) {
		pvs_order_approve( $product_id );
		pvs_commission_add( $product_id );

		pvs_coupons_add( pvs_order_user( $product_id ) );
		pvs_send_notification( 'neworder_to_user', $product_id );
		pvs_send_notification( 'neworder_to_admin', $product_id );
	}

	header( "location:" .site_url() . "/payment-success/" );
	exit();
}



if ( $payment_type != "cheque" ) {
	if ( $sent == true)
	{
		include ( PVS_PATH. "includes/payments/" . $payment_type . "/payment.php" );
	}
} else {
	pvs_transaction_add( "cheque", '', $product_type, $product_id );

	if ( $product_type == "credits" )
	{
		pvs_send_notification( 'credits_to_admin', $product_id );
	}

	if ( $product_type == "subscription" )
	{
		pvs_send_notification( 'subscription_to_admin', $product_id );
	}

	if ( $product_type == "order" )
	{
		pvs_send_notification( 'neworder_to_admin', $product_id );
	}
	header( "location:" . site_url() . "/payment-page/?payment=cheque&product_id=" . $product_id . "&product_type=" . $product_type . "&print=1" );
	exit();
}
?>