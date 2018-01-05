<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "prints_pwinty" );

$testmode = 0;
if ( isset( $_POST["testmode"] ) )
{
	$testmode = 1;
}

$usetrackedshipping = 0;
if ( isset( $_POST["usetrackedshipping"] ) )
{
	$usetrackedshipping = 1;
}

$sql = "update " . PVS_DB_PREFIX . "pwinty set account='" . pvs_result( $_POST["account"] ) .
	"',password='" . pvs_result( $_POST["password"] ) . "',order_number=" . ( int )
	$_POST["order_number"] . ",testmode=" . $testmode . ",usetrackedshipping=" . $usetrackedshipping .
	",payment='" . pvs_result( $_POST["payment"] ) . "',qualitylevel='" . pvs_result( $_POST["qualitylevel"] ) .
	"',photoresizing='" . pvs_result( $_POST["photoresizing"] ) . "'";
$db->execute( $sql );
?>