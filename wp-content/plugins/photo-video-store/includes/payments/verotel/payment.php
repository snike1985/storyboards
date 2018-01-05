<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["verotel_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

	include ( PVS_PATH . "includes/plugins/verotel/FlexPay.php" );

	$purchase_url = "";
	
	$user_info = get_userdata(get_current_user_id());

	$params = array(
		'shopID' => $pvs_global_settings["verotel_account"],
		'priceAmount' => pvs_price_format( $product_total, 2 ),
		'priceCurrency' => pvs_get_currency_code(1),
		'referenceID' => $product_type . "-" . $product_id,
		'description' => $product_name,
		'email' => @$user_info -> user_email,
		'version' => '3',
		'type' => 'purchase' );

	$purchase_url = FlexPay::get_purchase_URL( $pvs_global_settings["verotel_password"], $params );
?>
<form action="<?php echo $purchase_url ?>" method="post" name="process" id="process">
</form> 
<?php
pvs_show_payment_page( 'footer' );
?>