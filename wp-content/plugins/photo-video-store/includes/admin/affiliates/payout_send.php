<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_payout" );

$sql = "insert into " . PVS_DB_PREFIX .
	"affiliates_signups (total,userid,aff_referal,types,types_id,rates,data,status,gateway,description) values (" . ( -
	1 * $_POST["total"] ) . ",0," . ( int )$_POST["user"] . ",'refund',0,0," .
	pvs_get_time() . ",1,'" . pvs_result( $_POST["method"] ) . "','" . pvs_result( $_POST["description"] ) .
	"')";
$db->execute( $sql );


?>
