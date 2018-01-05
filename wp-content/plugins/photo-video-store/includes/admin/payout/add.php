<?php
// Exit if accessed directly.
if ( ! defined( 'ABSPATH' ) )
{
	exit;
}

//Check access
pvs_admin_panel_access( "settings_payout" );

$sql = "insert into " . PVS_DB_PREFIX . "payout (title, svalue,activ) values ('" . pvs_result( $_POST["new"] ) . "','" . str_replace(" ","_",strtolower(pvs_result( $_POST["new"] ))) . "',1)";
$db->execute( $sql );
?>