<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_coupons" );

$coupon_code = pvs_result( $_POST["code"] );
$flag = true;

if ( $coupon_code != "" ) {
	$sql = "select coupon_code from " . PVS_DB_PREFIX .
		"coupons where coupon_code='" . $coupon_code . "'";
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$flag = false;
	}
} else
{
	$flag = false;
}

if ( ! $flag ) {
	$coupon_code = substr(md5( pvs_create_password() . pvs_get_time() ), 0, 10);
}

$sql = "insert into " . PVS_DB_PREFIX .
	"coupons (title,user,data2,total,percentage,url,used,data,ulimit,tlimit,coupon_code,coupon_id) values ('" .
	pvs_result( $_POST["title"] ) . "','" . pvs_result( $_POST["user"] ) . "'," .
	pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
	date( "Y" ) ) . "," . ( float )$_POST["total"] . "," . ( float )$_POST["percentage"] .
	",'" . pvs_result( $_POST["url"] ) . "',0," . ( pvs_get_time( date( "H" ), date
	( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) + ( int )$_POST["days"] *
	3600 * 24 ) . "," . ( int )$_POST["limit_of_usage"] . ",0,'" . $coupon_code .
	"',0)";
$db->execute( $sql );

?>
