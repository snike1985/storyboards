<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["mellatbank_active"] ) {
	exit();
}

require_once ( PVS_PATH . "includes/plugins/mellatbank/nusoap.php" );

$client = new soapclient( 'https://pgwstest.bpm.bankmellat.ir/pgwchannel/services/pgw?wsdl' );
$namespace = 'http://interfaces.core.sw.bps.com/';

if ( $_POST ) {

	$terminalId = $pvs_global_settings["mellatbank_account"];
	$userName = $pvs_global_settings["mellatbank_account2"];
	$userPassword = $pvs_global_settings["mellatbank_pasword"];
	$orderId = $_POST['SaleOrderId'];
	$verifySaleOrderId = $_POST['SaleOrderId'];
	$verifySaleReferenceId = $_POST['SaleReferenceId'];

	// Check for an error
	$err = $client->getError();
	if ( $err ) {
		echo '<h2>Constructor error</h2><pre>' . $err . '</pre>';
		die();
	}

	$parameters = array(
		'terminalId' => $terminalId,
		'userName' => $userName,
		'userPassword' => $userPassword,
		'orderId' => $orderId,
		'saleOrderId' => $verifySaleOrderId,
		'saleReferenceId' => $verifySaleReferenceId );

	// Call the SOAP method
	$result = $client->call( 'bpVerifyRequest', $parameters, $namespace );

	// Check for a fault
	if ( $client->fault ) {
		echo '<h2>Fault</h2><pre>';
		print_r( $result );
		echo '</pre>';
		die();
	} else {

		$resultStr = $result;

		$err = $client->getError();
		if ( $err ) {
			// Display the error
			echo '<h2>Error</h2><pre>' . $err . '</pre>';
			die();
		} else {
			// Display the result
			// Update Table, Save Verify Status
			// Note: Successful Verify means complete successful sale was done.
			echo "<script>alert('Verify Response is : " . $resultStr . "');</script>";
			echo "Verify Response is : " . $resultStr;
			if ( $resultStr == 0 )
			{
				$mass = explode( "-", pvs_result( $_POST['SaleOrderId'] ) );
				$product_type = $mass[0];
				$id = ( int )$mass[1];
				$transaction_id = pvs_transaction_add( "mellatbank", pvs_result( $_POST['SaleReferenceId'] ),
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
		} // end Display the result
	} // end Check for errors

}
?>