<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["webpay_active"] ) {
	exit();
}

pvs_show_payment_page( 'header', true );

if ( $_GET ) {
	$postdata = '*API=&API_XML_REQUEST=' . urlencode( '
	<?php xml version="1.0" encoding="ISO-8859-1" ?>
	<wsb_api_request>
	<command>get_transaction</command>
	<authorization>
	<username>' . $pvs_global_settings["webpay_account2"] . '</username>
	<password>' . md5( $pvs_global_settings["webpay_password2"] ) . '</password>
	</authorization>
	<fields>
	<transaction_id>' . pvs_result( $_GET["wsb_tid"] ) . '
	</transaction_id>
	</fields>
	</wsb_api_request>
	' );

	if ( $pvs_global_settings["webpay_test"] ) {
		$curl = curl_init( "https://sandbox.webpay.by" );
	} else {
		$curl = curl_init( "https://billing.webpay.by" );
	}
	curl_setopt( $curl, CURLOPT_HEADER, 0 );
	curl_setopt( $curl, CURLOPT_POST, 1 );
	curl_setopt( $curl, CURLOPT_POSTFIELDS, $postdata );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYPEER, 0 );
	curl_setopt( $curl, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $curl, CURLOPT_SSL_VERIFYHOST, 0 );
	$response = curl_exec( $curl );
	curl_close( $curl );

	$res = new RecursiveIteratorIterator( new SimpleXMLIterator( $response ) );

	$arr = array();
	foreach ( $res as $property => $value ) {
		$arr[$property][] = ( string )$value;
	}

	$sec = md5( @$arr["transaction_id"][0] . @$arr["batch_timestamp"][0] . @$arr["currency_id"][0] .
		@$arr["amount"][0] . @$arr["payment_method"][0] . @$arr["payment_type"][0] . @$arr["order_id"][0] .
		@$arr["rrn"][0] . $pvs_global_settings["webpay_password"] );

	if ( $sec == @$arr["wsb_signature"][0] ) {
		if ( @$arr["payment_type"][0] == 1 or @$arr["payment_type"][0] == 4 ) {
			$mass = explode( "-", pvs_result( $_GET["wsb_order_num"] ) );
			$product_type = $mass[0];
			$id = ( int )$mass[1];
			$transaction_id = pvs_transaction_add( "webpay", pvs_result( $_GET["wsb_tid"] ),
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
	}
}

header( "HTTP/1.0 200 OK" );
?>

<h1><?php echo pvs_word_lang( "payment" )?></h1>

<?php
if ( @$arr["payment_type"][0] == 1 or @$arr["payment_type"][0] == 4 ) {
?>
	<p>Thank you! Your transaction has been sent successfully.</p>
	<?php
} else
{
?>
	<p>Error. The transaction has been declined!</p>
	<?php
}

pvs_show_payment_page( 'footer', true );
?>