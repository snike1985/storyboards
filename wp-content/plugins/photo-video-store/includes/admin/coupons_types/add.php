<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_couponstypes" );

if ( $_POST["discount_type"] == "total" )
{
	$com = "," . ( float )$_POST["discount"] . ",0";
}
if ( $_POST["discount_type"] == "percentage" )
{
	$com = ",0," . ( float )$_POST["discount"];
}

$sql = "insert into " . PVS_DB_PREFIX .
	"coupons_types (title,days,total,percentage,url,events,ulimit,bonus) values ('" .
	pvs_result( $_POST["title"] ) . "'," . ( int )$_POST["days"] . $com . ",'','" . pvs_result( $_POST["events"] ) . "'," . ( int )
	$_POST["ulimit"] . "," . ( float )$_POST["bonus"] . ")";
$db->execute( $sql );
?>