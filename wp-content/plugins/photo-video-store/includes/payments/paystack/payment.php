<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["paystack_active"] ) {
	exit();
}

pvs_show_payment_page( 'header' );

$user_info = get_userdata(get_current_user_id());

$purchase_url = "";

$data = array(
	"amount" => $product_total * 100,
	"reference" => $product_type . "-" . $product_id,
	"email" => @$user_info -> user_email );
$data_string = json_encode( $data );

$ch = curl_init();
curl_setopt( $ch, CURLOPT_URL, "https://api.paystack.co/transaction/initialize" );
curl_setopt( $ch, CURLOPT_RETURNTRANSFER, 1 );
curl_setopt( $ch, CURLOPT_POSTFIELDS, $data_string );
curl_setopt( $ch, CURLOPT_POST, 1 );

$headers = array();
$headers[] = "Authorization: Bearer " . $pvs_global_settings["paystack_password"];
$headers[] = "Content-Type: application/json";
curl_setopt( $ch, CURLOPT_HTTPHEADER, $headers );

$results = curl_exec( $ch );
if ( ! curl_errno( $ch ) ) {
	$res = json_decode( $results );
	$purchase_url = $res->data->authorization_url;
}
curl_close( $ch );

if ( $purchase_url != '' ) {
?>
	<form action="<?php echo $purchase_url
?>" method="post" name="process" id="process">
	</form> 
	<?php
}

pvs_show_payment_page( 'footer' );
?>