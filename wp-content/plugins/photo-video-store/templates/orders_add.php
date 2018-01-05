<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$userbalance = 0;

//Orders total
$sbt = ( float )$_SESSION["product_subtotal"];
$shipping = ( float )$_SESSION["product_shipping"];
$shipping_method = ( int )$_SESSION["product_shipping_type"];
$weight = ( float )$_SESSION["weight"];
$dsc = ( float )$_SESSION["product_discount"];
$taxes = ( float )$_SESSION["product_tax"];
$ttl = ( float )$_SESSION["product_total"];

unset( $_SESSION["checkout_steps"] );

//Credits balance
$credits = pvs_credits_balance();

//User_balance
//$userbalance=pvs_user_balance();
$userbalance = 0;

//Check if we have credits
if ( $pvs_global_settings["credits"] and $ttl > $credits + $userbalance ) {
	if ( ! $pvs_global_settings["credits_currency"] or ( $pvs_global_settings["credits_currency"] and
		@$_SESSION["checkout_method"] == "credits" ) ) {
		header( "location:" . site_url() . "/credits/" );
		exit();
	}
}

//Insert new order
$taxes_info = array();
$order_id = pvs_order_add( $sbt, $dsc, $ttl, $shipping, $taxes, $shipping_method,
	$weight );

//Use a coupon
if ( isset( $_SESSION["coupon_code"] ) ) {
	pvs_coupons_delete( $_SESSION["coupon_code"] );
	unset($_SESSION["coupon_code"]);
}

//Payout
$refund = 0;
if ( $userbalance > 0 ) {
	if ( $ttl >= $userbalance ) {
		$refund = $userbalance;
	}
	if ( $ttl < $userbalance ) {
		$refund = $ttl;
	}
	$sql = "insert into " . PVS_DB_PREFIX .
		"commission (total,user,orderid,item,publication,types,data,gateway,description) values (" . ( -
		1 * $refund ) . "," . get_current_user_id() . "," . $order_id .
		",0,0,'refund'," . pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ),
		date( "d" ), date( "Y" ) ) . ",'Website','New order #" . $order_id . "')";
	$db->execute( $sql );
}

//IF ORDER APPROVED
if ( ! $pvs_global_settings["credits"] or ( $pvs_global_settings["credits_currency"] and
	@$_SESSION["checkout_method"] == "currency" ) ) {
	/*
	if($ttl<=$userbalance) {
	pvs_order_approve($order_id);
	pvs_commission_add($order_id);
	pvs_coupons_add(pvs_get_user_login ());
	pvs_send_notification('neworder_to_user',$order_id);
	pvs_send_notification('neworder_to_admin',$order_id);
	}
	*/
} else
{
	pvs_order_approve( $order_id );
	pvs_commission_add( $order_id );
	if ( $ttl > $refund ) {
		pvs_credits_delete( $ttl - $refund, $order_id );
	}
	pvs_coupons_add( pvs_get_user_login () );
	pvs_send_notification( 'neworder_to_user', $order_id );
	pvs_send_notification( 'neworder_to_admin', $order_id );
}

$yandex_payments = "";
if ( isset( $_POST["yandex_payments"] ) ) {
	$yandex_payments = "&yandex_payments=" . pvs_result( $_POST["yandex_payments"] );
}

$telephone = "";
if ( isset( $_POST["telephone"] ) ) {
	$telephone = "&telephone=" . pvs_result( $_POST["telephone"] );
}

$moneyua_method = "";
if ( isset( $_POST["moneyua_method"] ) ) {
	$moneyua_method = "&moneyua_method=" . pvs_result( $_POST["moneyua_method"] );
}

$targetpay_banks = "";
if ( isset( $_POST["bank"] ) ) {
	$targetpay_banks = "&targetpay_banks=" . pvs_result( $_POST["bank"] );
}

if ( $ttl == 0 ) {
	pvs_order_approve( $order_id );
	pvs_commission_add( $order_id );
	pvs_coupons_add( pvs_get_user_login () );
	pvs_send_notification( 'neworder_to_user', $order_id );
	pvs_send_notification( 'neworder_to_admin', $order_id );
	if ( ! $pvs_global_settings["printsonly"] ) {
		header( "location:" . site_url() . "/profile-downloads/" );
	} else {
		header( "location:" . site_url() . "/orders/" );
	}
	exit();
}

//if($ttl>$userbalance and !$pvs_global_settings["credits"])
if ( ! $pvs_global_settings["credits"] or ( $pvs_global_settings["credits_currency"] and
	@$_SESSION["checkout_method"] == "currency" ) ) {
	unset( $_SESSION["checkout_method"] );
	header( "location:" . site_url() . "/payment-process/?order_id=" . $order_id . "&payment=" .
		pvs_result( $_POST["payment"] ) . "&tip=order" . $telephone . $moneyua_method .
		$yandex_payments . $targetpay_banks );
} else
{
	unset( $_SESSION["checkout_method"] );

	if ( ! $pvs_global_settings["printsonly"] ) {
		header( "location:" . site_url() . "/profile-downloads/" );
	} else {
		header( "location:" . site_url() . "/orders/" );
	}
}

?>