<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header', true );

if ( $pvs_global_settings["ccavenue_active"] ) {
	include ( PVS_PATH . 'includes/plugins/ccavenue/adler32.php' );
	include ( PVS_PATH . 'includes/plugins/ccavenue/Aes.php' );
	
	/*
	
	This is the sample RedirectURL PHP Page. It can be directly used for integration with CCAvenue if your application is developed in PHP. You need to simply change the variables to match your variables as well as insert routines for handling a successful or unsuccessful transaction.
	
	return values i.e the parameters below are passed as POST parameters by CCAvenue server 
	*/
	
	//---------------------------------------------------------------------------------------------------------------------------------//
	
	$workingKey = $pvs_global_settings["ccavenue_password"]; //Working Key should be provided here.
	$encResponse = $_POST["encResponse"]; //This is the response sent by the CCAvenue Server
	
	$rcvdString = decrypt( $encResponse, $workingKey ); //AES Decryption used as per the specified working key.
	$AuthDesc = "";
	$MerchantId = '';
	$OrderId = "";
	$Amount = 0;
	$Checksum = 0;
	$veriChecksum = false;
	
	$decryptValues = explode( '&', $rcvdString );
	$dataSize = sizeof( $decryptValues );
	//******************************    Messages based on Checksum & AuthDesc   **********************************//
	echo "<center>";
	
	for ( $i = 0; $i < $dataSize; $i++ ) {
		$information = explode( '=', $decryptValues[$i] );
		if ( $i == 0 )
			$MerchantId = $information[1];
		if ( $i == 1 )
			$OrderId = $information[1];
		if ( $i == 2 )
			$Amount = $information[1];
		if ( $i == 3 )
			$AuthDesc = $information[1];
		if ( $i == 4 )
			$Checksum = $information[1];
	}
	
	$rcvdString = $MerchantId . '|' . $OrderId . '|' . $Amount . '|' . $AuthDesc . '|' . $workingKey;
	$veriChecksum = verifyChecksum( genchecksum( $rcvdString ), $Checksum );
	
	if ( $veriChecksum == TRUE && $AuthDesc === "Y" ) {
		echo "<br>Thank you for shopping with us. Your credit card has been charged and your transaction is successful. We will be shipping your order to you soon.";
	
		//Here you need to put in the routines for a successful
		//transaction such as sending an email to customer,
		//setting database status, informing logistics etc etc
	
		$mass = explode( "-", pvs_result( $OrderId ) );
		$product_type = $mass[0];
		$id = ( int )$mass[1];
		$transaction_id = pvs_transaction_add( "ccavenue", '', pvs_result( $product_type ),
			$id );
	
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
	
	} else {
		if ( $veriChecksum == TRUE && $AuthDesc === "B" ) {
			echo "<br>Thank you for shopping with us.We will keep you posted regarding the status of your order through e-mail";
	
			//Here you need to put in the routines/e-mail for a  "Batch Processing" order
			//This is only if payment for this transaction has been made by an American Express Card
			//since American Express authorisation status is available only after 5-6 hours by mail from ccavenue and at the "View Pending Orders"
		} else {
			if ( $veriChecksum == TRUE && $AuthDesc === "N" ) {
				echo "<br>Thank you for shopping with us.However,the transaction has been declined.";
	
				//Here you need to put in the routines for a failed
				//transaction such as sending an email to customer
				//setting database status etc etc
			} else {
				echo "<br>Security Error. Illegal access detected";
	
				//Here you need to simply ignore this and dont need
				//to perform any operation in this condition
			}
	
			echo "<br><br>";
	
			//************************************  DISPLAYING DATA RCVD ******************************************//
			/*
			echo "<table cellspacing=4 cellpadding=4>";
			for($i = 0; $i < $dataSize; $i++) 
			{
			$information=explode('=',$decryptValues[$i]);
			echo '<tr><td>'.$information[0].'</td><td>'.$information[1].'</td></tr>';
			}
			
			echo "</table><br>";
			echo "</center>";
			*/
		} 
	}
}

pvs_show_payment_page( 'footer', true );
?>