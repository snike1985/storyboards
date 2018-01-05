<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["qiwi_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$SHOP_ID = $pvs_global_settings["qiwi_account"];
$REST_ID = $pvs_global_settings["qiwi_account2"];
$PWD = $pvs_global_settings["qiwi_password"];
$BILL_ID = $product_id . "-" . $product_type;
$PHONE = trim( str_replace( "+", "", $_REQUEST["telephone"] ) );

$data = array(
	"user" => "tel:+" . $PHONE,
	"amount" => pvs_price_format( $product_total, 2 ),
	"ccy" => pvs_get_currency_code(1),
	"comment" => $product_name,
	"lifetime" => date( "c", pvs_get_time( date( "H" ), date( "i" ), date( "s" ),
		date( "m" ), date( "d" ), date( "Y" ) ) + 3600 * 24 * 30 ),
	"pay_source" => "qw",
	"prv_name" => bloginfo('name') );

$ch = curl_init( 'https://api.qiwi.com/api/v2/prv/' . $SHOP_ID . '/bills/' . $BILL_ID );
curl_setopt( $ch, CURLOPT_SSL_VERIFYPEER, FALSE );
curl_setopt( $ch, CURLOPT_CUSTOMREQUEST, 'PUT' );
curl_setopt( $ch, CURLOPT_POSTFIELDS, http_build_query( $data ) );
curl_setopt( $ch, CURLOPT_POST, 1 );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, TRUE );
curl_setopt( $ch, CURLOPT_HTTPAUTH, CURLAUTH_BASIC );
curl_setopt( $ch, CURLOPT_USERPWD, $REST_ID . ":" . $PWD );
curl_setopt( $ch, CURLOPT_HTTPHEADER, array( "Accept: application/json" ) );
$results = curl_exec( $ch ) or die( curl_error( $ch ) );
//echo $results;
//echo curl_error($ch);
curl_close( $ch );
//Ќеоб€зательный редирект пользовател€
$url = 'https://qiwi.com/order/external/main.action?shop=' . $SHOP_ID . '&
transaction=' . urlencode( $BILL_ID ) . '&successUrl=' . urlencode( site_url( ) . "/payment-success/" ) . '&failUrl=' . urlencode( site_url( ) . "/payment-fail/" ) . '&qiwi_phone=' . $PHONE;
?>
<form method="post" action="<?php echo $url
?>" name="process" id="process">

</form>

<?php
pvs_show_payment_page( 'footer' );
?>