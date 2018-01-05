<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "orders_commission" );

$bank_info = "";
if ( $_POST["method"] == "bank" and @$_POST["bank_name"] != "" and @$_POST["bank_account"] !=
	"" ) {
	$bank_info = "\n" . pvs_result( @$_POST["bank_name"] ) . ": " . pvs_result( @$_POST["bank_account"] );
}

$sql = "insert into " . PVS_DB_PREFIX .
	"commission (total,user,orderid,item,publication,types,data,gateway,description,status) values (" . ( -
	1 * $_POST["total"] ) . "," . ( int )$_POST["user"] . ",0,0,0,'refund'," .
	pvs_get_time( date( "H" ), date( "i" ), date( "s" ), date( "m" ), date( "d" ),
	date( "Y" ) ) . ",'" . pvs_result( $_POST["method"] ) . "','" . pvs_result( $_POST["description"] ) .
	$bank_info . "',1)";
$db->execute( $sql );

$product_type = "payout_seller";
$link_back = pvs_plugins_admin_url('commission/index.php') . "&d=2";

//include ( "gateways.php" );
?>
