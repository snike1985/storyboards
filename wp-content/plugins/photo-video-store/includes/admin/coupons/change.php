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
		"coupons where coupon_code='" . $coupon_code . "' and id_parent<>" . ( int )$_REQUEST["id"];
	$rs->open( $sql );
	if ( ! $rs->eof ) {
		$flag = false;
	}
} else
{
	$flag = false;
}

if ( ! $flag ) {
	$coupon_code = md5( pvs_create_password() . pvs_get_time( date( "H" ), date( "i" ),
		date( "s" ), date( "m" ), date( "d" ), date( "Y" ) ) );
}

$sql = "select * from " . PVS_DB_PREFIX . "coupons where id_parent=" . ( int )$_REQUEST["id"];
$rs->open( $sql );
if ( ! $rs->eof ) {
	$sql = "update " . PVS_DB_PREFIX . "coupons set title='" . pvs_result( $_POST["title"] ) .
		"',user='" . pvs_result( $_POST["user"] ) . "',total=" . ( float )$_POST["total"] .
		",percentage=" . ( float )$_POST["percentage"] . ",url='" . pvs_result( $_POST["url"] ) .
		"',data=" . ( $rs->row["data2"] + ( int )$_POST["days"] * 3600 * 24 ) .
		",ulimit=" . ( int )$_POST["limit_of_usage"] . ",coupon_code='" . $coupon_code .
		"' where id_parent=" . ( int )$_REQUEST["id"];
	$db->execute( $sql );
}

?>
