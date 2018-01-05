<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["midtrans_active"] ) {
	exit();
}


pvs_show_payment_page( 'header' );

require_once ( PVS_PATH . 'includes/plugins/veritrans/Veritrans.php' );
//Set Your server key
Veritrans_Config::$serverKey = $pvs_global_settings["midtrans_password"];

// Uncomment for production environment
if ( $pvs_global_settings["midtrans_test"] ) {
	Veritrans_Config::$isProduction = false;
} else {
	Veritrans_Config::$isProduction = true;
}

// Uncomment to enable sanitization
// Veritrans_Config::$isSanitized = true;

// Uncomment to enable 3D-Secure
// Veritrans_Config::$is3ds = true;

// Required
$transaction_details = array(
	'order_id' => $product_type . "-" . $product_id,
	//'gross_amount' => float_opt( $product_total, 2 ), // no decimal allowed for creditcard
	'gross_amount' => round( $product_total )
	);

// Fill transaction details
$transaction = array( 'transaction_details' => $transaction_details );

try
{
	$url = Veritrans_VtWeb::getRedirectionUrl( $transaction );
	// Redirect to Veritrans VTWeb page

?>
  <form action="<?php echo $url
?>" method="get" name="process" id="process"></form>
  <?php
}
catch ( Exception $e ) {
	echo $e->getMessage();
	if ( strpos( $e->getMessage(), "Access denied due to unauthorized" ) ) {
		echo "<code>";
		echo "<h4>Please set real server key from sandbox</h4>";
		echo "In file: " . __FILE__;
		echo "<br>";
		echo "<br>";
		echo htmlspecialchars( 'Veritrans_Config::$serverKey = \'' . $pvs_global_settings["midtrans_password"] .
			'\';' );
		die();
	}
}


pvs_show_payment_page( 'footer' );
?>