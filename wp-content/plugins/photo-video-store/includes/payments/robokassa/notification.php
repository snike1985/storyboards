<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

if ( ! $pvs_global_settings["robokassa_active"] ) {
	exit();
}

// регистрационная информация (пароль #2)
// registration info (password #2)
$mrh_pass2 = $pvs_global_settings["robokassa_password2"];

// чтение параметров
// read parameters
$out_summ = $_REQUEST["OutSum"];
$inv_id = $_REQUEST["InvId"];
$shp_item = $_REQUEST["Shp_item"];
$crc = $_REQUEST["SignatureValue"];

$crc = strtoupper( $crc );

$my_crc = strtoupper( md5( "$out_summ:$inv_id:$mrh_pass2:Shp_item=$shp_item" ) );

// build own CRC
//$my_crc = strtoupper(md5("$out_summ:$inv_id:$mrh_pass2"));
if ( strtoupper( $my_crc ) != strtoupper( $crc ) ) {
	echo "bad sign\n";
	exit();
}

// признак успешно проведенной операции
// success
echo "OK$inv_id\n";

$id = ( int )$inv_id;
$product_type = pvs_result( $shp_item );

$transaction_id = pvs_transaction_add( "robokassa", '', $product_type, $id );

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

?>