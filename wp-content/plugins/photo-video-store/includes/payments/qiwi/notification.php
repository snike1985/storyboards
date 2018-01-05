<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["qiwi_active"] ) {
	exit();
}

function hexToStr( $hex ) {
	$string = '';
	for ( $i = 0; $i < strlen( $hex ) - 1; $i += 2 ) {
		$string .= chr( hexdec( $hex[$i] . $hex[$i + 1] ) );
	}
	return $string;
}
//функция генерации подписи по ключу и строке параметров
function checkSign( $key, $req ) {
	$sign_hash = hash_hmac( "sha1", $req, $key );
	$sign_tr = hexToStr( $sign_hash );
	$sign = base64_encode( $sign_tr );
	return $sign;
}
//Функция возвращает упорядоченную строку значений параметров POST-запроса
function getReqParams() {
	$reqparams = "";
	ksort( $_POST );
	foreach ( $_POST as $param => $valuep ) {
		$reqparams = "$reqparams|$valuep";
	}
	return substr( $reqparams, 1 );
}
//Извлечение цифровой подписи из заголовков запроса
function getSign() {
	$HEADERS = getallheaders();
	foreach ( $HEADERS as $header => $value ) {
		if ( $header == 'X-Api-Signature' ) {
			$SIGN_REQ = $value;
		}
	}
	return $SIGN_REQ;
}

// Сортировка параметров
$Request = getReqParams();
// Пароль ishop для уведомлений магазина
$NOTIFY_PWD = $pvs_global_settings["qiwi_password2"];
// Вычисляем подпись
$reqres = checkSign( $NOTIFY_PWD, $Request );
// Подпись из запроса
$SIGN_REQ = getSign();
if ( $reqres == $SIGN_REQ ) {
	$error = 0;

	if ( $_POST["status"] == "paid" ) {
		$_POST["bill_id"] = str_replace( "_TEST_", "", $_POST["bill_id"] );
		$product_mass = explode( "-", $_POST["bill_id"] );

		$id = ( int )$product_mass[0];
		$product_type = $product_mass[1];
		
		
		$transaction_id = pvs_transaction_add( "qiwi", $_POST["bill_id"], $product_type, $id );

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
} else
	$error = 150;

//Ответ
ob_clean();
header( 'Content-Type: text/xml' );
$xmlres = <<< XML
<?php xml version="1.0"?>
<result>
<result_code>$error</result_code>
</result>
XML;
echo $xmlres;
?>