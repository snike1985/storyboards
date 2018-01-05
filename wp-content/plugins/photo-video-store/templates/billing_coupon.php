<?php
if ( ! defined( 'ABSPATH' ) )
{
	exit();
}

if ( ! is_user_logged_in() ) {	
	exit();
}

$sql = "select coupon_code from " . PVS_DB_PREFIX .
	"coupons where coupon_code='" . pvs_result( $_POST["coupon"] ) .
	"' and (total<>0 or percentage<>0) and used=0 and data>" . pvs_get_time( date( "H" ),
	date( "i" ), date( "s" ), date( "m" ), date( "d" ), date( "Y" ) );
$rs->open( $sql );
if ( ! $rs->eof ) {
	$_SESSION["coupon_code"] = pvs_result( $_POST["coupon"] );
	header( "location:" . site_url() . "/billing/" );
} else
{
	header( "location:" . site_url() . "/billing/?coupon=1" );
}
?>



