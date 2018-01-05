<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

pvs_show_payment_page( 'header', true );
if ( $pvs_global_settings["checkoutfi_active"] ) {
?>
	<h1>Checkout.fi &mdash; <?php echo pvs_word_lang( "select payment method" )?></h1>
	
	<?php
	include ( PVS_PATH . 'includes/plugins/checkout.fi/CheckoutFinland/Payment.php' );
	include ( PVS_PATH . 'includes/plugins/checkout.fi/CheckoutFinland/Client.php' );
	
	$demo_merchant_id = $pvs_global_settings["checkoutfi_account"] ;
	$demo_merchant_secret = $pvs_global_settings["checkoutfi_password"];
	$return_url = site_url( ) . "/payment-notification/?payment=checkoutfi";
	
	$payment = new Payment( $demo_merchant_id, $demo_merchant_secret );
	$payment->setUrls( $return_url );
	
	$payment_data = array(
		'stamp' => time(), // stamp is the unique id for this transaction
		'amount' => ( $product_total * 100 ), // amount is in cents
		'reference' => $product_type . "-" . $product_id, // some reference id (perhaps order id)
		'message' => $product_type, // some short description about the order
	
		'deliveryDate' => date( "Y" ) . date( "m" ) . date( "d" ), // approximated delivery date, this is shown to customer service in Checkout Finland but not to the buyer
		/*
		'firstName'     => $_POST['first-name'],
		'familyName'    => $_POST['last-name'],
		'address'       => $_POST['address'],
		'postOffice'    => $_POST['post-office'],
		'postcode'      => $_POST['zip-code'],
		*/
		'country' => 'FIN', // country affects what payment options are shown FIN = all, others = credit cards
		'language' => 'EN' );
	
	$payment->setData( $payment_data );
	
	$client = new Client();
	
	$response = $client->sendPayment( $payment );
	
	if ( $response ) {
		$xml = @simplexml_load_string( $response ); // use @ to suppress warnings, checkout finland responds with an error string instead of xml if something went wrong
	
		if ( $xml and isset( $xml->id ) ) {
			// now we have a proper response xml and can show payment options to customer
	
			// here you can pass the xml to your view for rendering or something else
			// we just render the payment options a bit further down this file
	
		} else {
			// something went wrong, check merchant id and secret and after that every other parameter
			// do some error handling
			var_dump( $response );
		}
	} else
	{
		// no response at all, maybe the server is down, do some error handling
	}
	?>
	
	
			<?php
	if ( $xml and isset( $xml->id ) ) {
		$html = '';
	
		foreach ( $xml->payments->payment->banks as $bankX ) {
			foreach ( $bankX as $bank ) {
				$html .= "<div style='float: left; margin-right: 20px; min-height: 100px;width:150px' text-align: center;><form action='{$bank['url']}' method='post'><p>\n";
				foreach ( $bank as $key => $value )
				{
					$html .= "<input type='hidden' name='$key' value='$value' />\n";
				}
				$html .= "<span><input type='image' src='{$bank['icon']}' /></span><div><p>{$bank['name']}</p></div></form></div>\n";
			}
		}
	}
	echo "$html<div style='clear:both;'></div></div></div>";
}
pvs_show_payment_page( 'footer', true );
?>