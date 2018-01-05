<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( $pvs_global_settings["epaykkbkz_active"] ) {
	require_once ( PVS_PATH . "includes/plugins/epaykkbkz/kkb.utils.php" );
	
	$self = $_SERVER['PHP_SELF'];
	$path1 = PVS_PATH . 'includes/plugins/epaykkbkz/config.txt';
	$result = 0;
	if ( isset( $_POST["response"] ) ) {
		$response = $_POST["response"];
	}
	;
	$result = process_response( stripslashes( $response ), $path1 );

	if ( is_array( $result ) ) {
		if ( in_array( "ERROR", $result ) ) {
			if ( $result["ERROR_TYPE"] == "ERROR" ) {
				echo "System error:" . $result["ERROR"];
			} elseif ( $result["ERROR_TYPE"] == "system" ) {
				echo "Bank system error > Code: '" . $result["ERROR_CODE"] . "' Text: '" . $result["ERROR_CHARDATA"] .
					"' Time: '" . $result["ERROR_TIME"] . "' Order_ID: '" . $result["RESPONSE_ORDER_ID"] .
					"'";
			} elseif ( $result["ERROR_TYPE"] == "auth" ) {
				echo "Bank system user autentication error > Code: '" . $result["ERROR_CODE"] .
					"' Text: '" . $result["ERROR_CHARDATA"] . "' Time: '" . $result["ERROR_TIME"] .
					"' Order_ID: '" . $result["RESPONSE_ORDER_ID"] . "'";
			}
			;
		}
		;
		if ( in_array( "DOCUMENT", $result ) ) {
			echo "Result DATA: <BR>";
			foreach ( $result as $key => $value ) {
				echo "Postlink Result: " . $key . " = " . $value . "<br>";
			}
			;
	
			//Test
			//$result["ORDER_ORDER_ID"]="000123";
			//$result["CUSTOMER_MAIL"]="buyer@cmsaccount.com";
	
			//Oпределяем что это заказ, кредитс или подписка
			$id = ( int )$result["ORDER_ORDER_ID"];
			$email = $result["CUSTOMER_MAIL"];
	
			//User
			$sql = "select ID, user_login from " . $table_prefix . "users where user_email='" .
				pvs_result( $email ) . "'";
			$rs->open( $sql );
			if ( ! $rs->eof ) {
				//Orders
				$sql = "select id from " . PVS_DB_PREFIX . "orders where id=" . $id .
					" and user=" . $rs->row["ID"] . " and status=0";
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					pvs_order_approve( $id );
					pvs_commission_add( $id );
	
					pvs_coupons_add( pvs_order_user( $id ) );
					pvs_send_notification( 'neworder_to_user', $id );
					pvs_send_notification( 'neworder_to_admin', $id );
				}
	
				//Credits
				$sql = "select id_parent from " . PVS_DB_PREFIX .
					"credits_list where id_parent=" . $id . " and user='" . $rs->row["user_login"] .
					"' and approved=0";
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					pvs_credits_approve( $id, $result["PAYMENT_REFERENCE"] );
					pvs_send_notification( 'credits_to_user', $id );
					pvs_send_notification( 'credits_to_admin', $id );
				}
	
				//Subscription
				$sql = "select id_parent from " . PVS_DB_PREFIX .
					"subscription_list where id_parent=" . $id . " and user='" . $rs->row["user_login"] .
					"' and approved=0";
				$ds->open( $sql );
				if ( ! $ds->eof )
				{
					pvs_subscription_approve( $id );
					pvs_send_notification( 'subscription_to_user', $id );
					pvs_send_notification( 'subscription_to_admin', $id );
				}
			}
	
		}
	} else
	{
		echo "System error" . $result;
	}
}
?>