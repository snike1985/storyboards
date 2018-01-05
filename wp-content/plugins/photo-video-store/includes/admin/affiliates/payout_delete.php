<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}
//Check access
pvs_admin_panel_access( "affiliates_payout" );

$sql = "delete from " . PVS_DB_PREFIX . "affiliates_signups where data=" . ( int )
	$_GET["data"] . " and aff_referal=" . ( int )$_GET["aff_referal"];
$db->execute( $sql );

?>
