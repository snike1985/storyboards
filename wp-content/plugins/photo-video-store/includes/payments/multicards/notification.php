<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["multicards_active"] ) {
	exit();
}

if ( ! $pvs_global_settings["multicards_ipn"] ) {
	exit();
}

$multicards_ok = true;

if ( $_POST["SilentPostPassword"] != $pvs_global_settings["multicards_account3"] )
{
	$multicards_ok = false;
}
if ( ( int )$_POST["mer_id"] != $pvs_global_settings["multicards_account"] )
{
	$multicards_ok = false;
}
//if($_POST["status"]!="accepted"){$multicards_ok=false;}

echo ( "<!--success-->" );
if ( $multicards_ok == true )
{

	$transaction_id = pvs_transaction_add( "multicards", $_POST["order_num"], $_POST["item1_desc"],
		$_POST["user1"] );

	if ( $_POST["item1_desc"] == "credits" and ! pvs_is_order_approved( $_POST["user1"], 'credits' ) )
	{
		pvs_credits_approve( $_POST["user1"], $transaction_id );
		pvs_send_notification( 'credits_to_user', $_POST["user1"] );
		pvs_send_notification( 'credits_to_admin', $_POST["user1"] );
	}

	if ( $_POST["item1_desc"] == "subscription" and ! pvs_is_order_approved( $_POST["user1"], 'subscription' ) )
	{
		pvs_subscription_approve( $_POST["user1"] );
		pvs_send_notification( 'subscription_to_user', $_POST["user1"] );
		pvs_send_notification( 'subscription_to_admin', $_POST["user1"] );
	}

	if ( $_POST["item1_desc"] == "order" and ! pvs_is_order_approved( $_POST["user1"], 'order' ) )
	{
		pvs_order_approve( $_POST["user1"] );
		pvs_commission_add( $_POST["user1"] );
		pvs_coupons_add( pvs_order_user( $_POST["user1"] ) );
		pvs_send_notification( 'neworder_to_user', $_POST["user1"] );
		pvs_send_notification( 'neworder_to_admin', $_POST["user1"] );
	}
}
?>