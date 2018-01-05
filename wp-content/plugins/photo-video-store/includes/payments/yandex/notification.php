<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["yandex_active"] ) {
	exit();
}


$hash = md5( $_POST['action'] . ';' . $_POST['orderSumAmount'] . ';' . $_POST['orderSumCurrencyPaycash'] .
	';' . $_POST['orderSumBankPaycash'] . ';' . $_POST['shopId'] . ';' . $_POST['invoiceId'] .
	';' . $_POST['customerNumber'] . ';' . $pvs_global_settings["yandex_password"] );
header( 'Content-Type: application/xml' );

if ( strtolower( $hash ) != strtolower( $_POST['md5'] ) and ( isset( $_POST['md5'] ) ) ) {
	$code = 1;
	echo '<?php xml version="1.0" encoding="UTF-8"?><checkOrderResponse performedDatetime="' .
		$_POST['requestDatetime'] . '" code="' . $code . '"' . ' invoiceId="' . $_POST['invoiceId'] .
		'" shopId="' . $pvs_global_settings["yandex_account"] . '" message="bad md5"/>';
	exit();
}

$crc = explode( "-", $_POST['orderNumber'] );
$id = ( int )$crc[1];
$product_type = pvs_result( $crc[0] );

$product_total = 0;

if ( $product_type == 'credits' ) {
	$sql = 'select total from " . PVS_DB_PREFIX . "credits_list where id_parent=' . ( int )
		$id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$product_total = $rs->row["total"];
	}
}
if ( $product_type == 'subscription' ) {
	$sql = 'select total from " . PVS_DB_PREFIX . "subscription_list where id_parent=' . ( int )
		$id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$product_total = $rs->row["total"];
	}
}
if ( $product_type == 'order' ) {
	$sql = 'select total from " . PVS_DB_PREFIX . "orders where id=' . ( int )$id;
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$product_total = $rs->row["total"];
	}
}

if ( $_POST['action'] == 'checkOrder' ) {
	if ( $product_total != $_POST['orderSumAmount'] ) {
		$code = 100;
	} else {
		$code = 0;
	}
	$answer = '<?php xml version="1.0" encoding="UTF-8"?><checkOrderResponse performedDatetime="' .
		date( 'c' ) . '" code="' . $code . '" invoiceId="' . $_POST['invoiceId'] .
		'" shopId="' . $pvs_global_settings["yandex_account"] . '" />';
	echo ( $answer );
	exit();
}

if ( $_POST['action'] == 'paymentAviso' ) {
	if ( $product_total == $_POST['orderSumAmount'] ) {
		$transaction_id = pvs_transaction_add( "yandex.money", "", $product_type, $id );

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

	$answer = '<?php xml version="1.0" encoding="UTF-8"?><paymentAvisoResponse performedDatetime="' .
		date( 'c' ) . '" code="0" invoiceId="' . $_POST['invoiceId'] . '" shopId="' . $pvs_global_settings["yandex_account"] .
		'" />';
	echo ( $answer );
	exit();
}
?>