<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header' );

if ( $pvs_global_settings["bitpay_active"] ) {
	$purchase_url = "";

	$data["price"] = $product_total;
	$data["currency"] = pvs_get_currency_code(1);
	$data["notificationURL"] = site_url( ) . "/payment-notification/?payment=bitpay";
	$data["transactionSpeed"] = "high";
	$data["fullNotifications"] = false;
	$data["notificationEmail"] = get_option( 'admin_email' );
	$data["redirectURL"] = site_url( ) . "/payment-success/";
	$data["orderId"] = $product_type . "-" . $product_id;
	$data["itemDesc"] = $product_name;
	
	$user_info = get_userdata(get_current_user_id());
	
	$data['buyerName'] = @$user_info -> first_name . ' ' . @$user_info -> last_name;
	$data['buyerEmail'] = @$user_info -> user_email;

	$posData["product_id"] = $product_id;
	$posData["product_type"] = $product_type;

	$data['posData'] = json_encode( $posData );

	$data_string = json_encode( $data );

	$ch = curl_init();
	if ( $pvs_global_settings["bitpay_test"] ) {
		curl_setopt( $ch, CURLOPT_URL, "https://test.bitpay.com/api/invoice/" );
	} else {
		curl_setopt( $ch, CURLOPT_URL, "https://bitpay.com/api/invoice/" );
	}
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
	curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
	curl_setopt( $ch, CURLOPT_POST, 1 );

	$headers = array();
	$headers[] = "Authorization: Basic " . base64_encode( $pvs_global_settings["bitpay_account"]);
	$headers[] = "Content-Type: application/json";
	$headers[] = "Content-Length: " . strlen( $data_string );
	curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );
	curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );

	$results = curl_exec( $ch );
	if ( ! curl_errno( $ch ) ) {
		$res = json_decode( $results );
		$purchase_url = $res->url;
	} else {
		echo ( curl_error( $ch ) );
	}
	curl_close( $ch );

	if ( $purchase_url != '' ) {
		?>
		<form method="post" action="<?php echo($purchase_url );?>"  name="process" id="process">
		</form>
		<?php
	}
}

pvs_show_payment_page( 'footer' );
?>