<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["clickbank_active"] ) {
	if ( $pvs_global_settings["clickbank_ipn"] ) {
		function cbValid()
		{
			global $pvs_global_settings;
			$key = $pvs_global_settings["clickbank_account2"];
			$ccustname = $_REQUEST['ccustname'];
			$ccustemail = $_REQUEST['ccustemail'];
			$ccustcc = $_REQUEST['ccustcc'];
			$ccuststate = $_REQUEST['ccuststate'];
			$ctransreceipt = $_REQUEST['ctransreceipt'];
			$cproditem = $_REQUEST['cproditem'];
			$ctransaction = $_REQUEST['ctransaction'];
			$ctransaffiliate = $_REQUEST['ctransaffiliate'];
			$ctranspublisher = $_REQUEST['ctranspublisher'];
			$cprodtype = $_REQUEST['cprodtype'];
			$cprodtitle = $_REQUEST['cprodtitle'];
			$ctranspaymentmethod = $_REQUEST['ctranspaymentmethod'];
			$ctransamount = $_REQUEST['ctransamount'];
			$caffitid = $_REQUEST['caffitid'];
			$cvendthru = $_REQUEST['cvendthru'];
			$cbpop = $_REQUEST['cverify'];

			$xxpop = sha1( "$ccustname|$ccustemail|$ccustcc|$ccuststate|$ctransreceipt|$cproditem|$ctransaction|" .
				"$ctransaffiliate|$ctranspublisher|$cprodtype|$cprodtitle|$ctranspaymentmethod|$ctransamount|$caffitid|$cvendthru|$key" );

			$xxpop = strtoupper( substr( $xxpop, 0, 8 ) );

			if ( $cbpop == $xxpop )
				return 1;
			else
				return 0;
		}

		$rz = cbValid();

		if ( $rz )
		{
			$mass = explode( "-", pvs_result( $_GET["seed"] ) );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			
			$transaction_id = pvs_transaction_add( "clickbank", "", $product_type, $product_id );
			
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

		}
	}
}
?>