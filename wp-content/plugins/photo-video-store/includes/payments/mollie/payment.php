<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["mollie_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

try
{
	$api_key = $pvs_global_settings["mollie_account"];
	include PVS_PATH . "includes/plugins/mollie/examples/initialize.php";

	$order_id = $product_type . "-" . $product_id;

	/*
	* Payment parameters:
	*   amount        Amount in EUROs. This example creates a ˆ 10,- payment.
	*   description   Description of the payment.
	*   webhookUrl    Custom webhook location, used instead of the default webhook URL in the Website profile.
	*   redirectUrl   Redirect location. The customer will be redirected there after the payment.
	*   metadata      Custom metadata that is stored with the payment.
	*/
	$payment = $mollie->payments->create( array(
		"amount" => pvs_price_format( $product_total, 2 ),
		"description" => $product_name,
		"webhookUrl" => site_url( ) . "/payment-notification/?payment=mollie",
		"redirectUrl" => site_url( ) . "/payment-success/",
		"metadata" => array( "order_id" => $order_id, ),
		) );?>
	<form action="<?php echo $payment->getPaymentUrl()?>" method="POST" name="process" id="process"> 
	</form>
	<?php
}
catch ( Mollie_API_Exception $e ) {
	echo "API call failed: " . htmlspecialchars( $e->getMessage() );
}

pvs_show_payment_page( 'footer' );
?>