<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["segpay_active"] ) {
	exit();
}

/* Fix it
if ( strtolower( $_REQUEST['approved'] ) == 'yes' ) {
	if ( $_REQUEST["product_type"] == "credits" )
	{
		pvs_credits_approve( $_REQUEST["product_id"], $_REQUEST["trans_id"] );
		pvs_send_notification( 'credits_to_user', $_REQUEST["product_id"] );
		pvs_send_notification( 'credits_to_admin', $_REQUEST["product_id"] );
	}

	if ( $_REQUEST["product_type"] == "subscription" )
	{
		pvs_subscription_approve( $_REQUEST["product_id"] );
		pvs_send_notification( 'subscription_to_user', $_REQUEST["product_id"] );
		pvs_send_notification( 'subscription_to_admin', $_REQUEST["product_id"] );
	}
	echo ( "success" );
}
*/
?>